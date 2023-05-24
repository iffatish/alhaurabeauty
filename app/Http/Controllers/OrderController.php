<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductQuantity;
use App\Models\OrderInformation;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function viewOrderList()
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $product = Product::get();
            $order = OrderInformation::where('employeeId', Auth::id())->orderBy('orderDate','DESC')->get();

            //count total items
            $total_items = array();
            foreach($order as $o)
            {
                $total = 0;
                foreach($product as $data)
                {
                    $col = $data->productId . "_order_qty";
                    $total += $o->$col;
                }
                array_push($total_items , $total);
            }
            
            return view('OrderModule.view_order_list')->with(['user'=> $user, 'product'=> $product, 'order'=> $order, 'total_items' => $total_items]);
        }
        return redirect('login');
    }

    public function viewOrder()
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $product = Product::get();
            $user_stock = ProductQuantity::where('employeeId', Auth::id())->first();
            
            return view('OrderModule.view_order')->with(['user'=> $user, 'product'=> $product]);
        }
        return redirect('login');
    }

    public function viewAddOrder()
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $product = Product::get();
            $user_stock = ProductQuantity::where('employeeId', Auth::id())->first();
            
            return view('OrderModule.add_order')->with(['user'=> $user, 'product'=> $product]);
        }
        return redirect('login');
    }

    public function addOrder(Request $request)
    {
        if(Auth::check())
        {
            $request->validate([
                'custName' => 'required',
                'custPhoneNum' => 'required',
                'deliveryAddress' => 'required',
                'deliveryMethod' => 'required',
                'paymentMethod' => 'required',
                'additionalCost' => 'required',
                'orderDate' => 'required'
            ]);
            
            $user = User::where('id', Auth::id())->first();
            $data = $request->all();
            $all_product = Product::get();
            $total_price = 0;

            //add row in Order Information
            $order = new OrderInformation;
            $order->custName = $data['custName'];
            $order->custPhoneNum = $data['custPhoneNum'];
            $order->deliveryAddress = $data['deliveryAddress'];
            $order->deliveryMethod = $data['deliveryMethod'];
            $order->paymentMethod = $data['paymentMethod'];
            $order->additionalCost = $data['additionalCost'];
            $order->orderDate = $data['orderDate'];
            foreach($all_product as $d)
            {
                $product_qty = $d->productId . "_order_qty";
                $product_price = $d->productId . "_order_price";
                $order->$product_qty = $data[$product_qty];

                if($d->productDiscountPrice > 0)
                {
                    $order->$product_price = $d->productDiscountPrice;
                    $total_price += $d->productDiscountPrice * $data[$product_qty];
                }else
                {
                    $order->$product_price = $d->productSellPrice;
                    $total_price += $d->productSellPrice * $data[$product_qty];
                }
                
            }
            $order->orderPrice = $total_price + $data['additionalCost'];
            $order->employeeId = Auth::id();
            $order->save();

            //update product_quantity table
            $product_qty_user = ProductQuantity::where('employeeId', Auth::id())->first();
            foreach($all_product as $dt)
            {
                $name = $dt->productId . "_order_qty";
                $column = $dt->productId . "_qty";
                $product_quantity = ProductQuantity::where('employeeId', Auth::id())->value($column);
                
                $total = $product_quantity - $data[$name];
                $product_qty_user->$column = $total;              
            }
            $product_qty_user->save();

            return redirect()->route('view_order_list')->with(['user'=> $user, 'product'=> $all_product, 'success'=>'New order successfully added!']);
        }
        return redirect('login');
    }

    public function viewOrderDetails(Request $request)
    {
        if(Auth::check())
        {
            $orderId = $request->orderId;
            $order = OrderInformation::where('orderId', $orderId)->first();
            
            $user = User::where('id', Auth::id())->first();
            $product = Product::get();

            $total_items = 0;
            $product_ordered = collect();
            foreach($product as $data)
            {
                $col = $data->productId . "_order_qty";
                $total_items += $order->$col;

                if($order->$col != 0){
                    $product_ordered->push($data);
                }
            }

            return view('OrderModule.view_order_details')->with([
                                                            'user'=> $user,
                                                            'order'=> $order, 
                                                            'orderId' => $order->orderId,
                                                            'total_items' => $total_items,
                                                            'product_ordered' => $product_ordered
                                                            ]);
        }
        return redirect('login');
    }
    //AJAX

    public function validateQuantityStock(Request $request) {
       
        $id = $request->id_;
        $col = $id . "_qty";
       
        $product_qty = ProductQuantity::where('employeeId',Auth::id())->first();

        return response()->json($product_qty->$col);
    }
}
