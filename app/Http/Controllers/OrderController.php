<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductQuantity;
use App\Models\OrderInformation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function viewOrderList()
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $order = OrderInformation::where('employeeId', Auth::id())->orderBy('orderDate','DESC')->get();
            
            return view('OrderModule.view_order_list')->with(['user'=> $user,'order'=> $order]);
        }
        return redirect('login');
    }

    public function viewAddOrder()
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $product = Product::where('status_data',1)->get();
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
            $all_product = Product::where('status_data',1)->get();
            $total_price = 0;
            $total_items = 0;
            //add row in Order Information
            $order = new OrderInformation;
            $order->custName = $data['custName'];
            $order->custPhoneNum = $data['custPhoneNum'];
            $order->deliveryAddress = $data['deliveryAddress'];
            $order->deliveryMethod = $data['deliveryMethod'];
            $order->paymentMethod = $data['paymentMethod'];
            $order->additionalCost = $data['additionalCost'];
            $order->orderDate = Carbon::createFromFormat('d-m-Y',$data['orderDate'])->format('Y-m-d');
            foreach($all_product as $d)
            {
                $product_qty = $d->productId . "_order_qty";
                $product_price = $d->productId . "_order_price";
                $order->$product_qty = $data[$product_qty];
                $total_items += $data[$product_qty];

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
            $order->totalItems = $total_items;
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

            $report_daily = (new ReportController)->editDailySalesReport($user);
            $report_monthly = (new ReportController)->editMonthlySalesReport($user);
            $report_yearly = (new ReportController)->editYearlySalesReport($user);

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

            $product_ordered = collect();
            foreach($product as $data)
            {
                $col = $data->productId . "_order_qty";

                if($order->$col != 0){
                    $product_ordered->push($data);
                }
            }

            return view('OrderModule.view_order_details')->with([
                                                            'user'=> $user,
                                                            'order'=> $order, 
                                                            'orderId' => $order->orderId,
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
