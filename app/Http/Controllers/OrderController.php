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
            $user_stock = ProductQuantity::where('employeeId', Auth::id())->first();
            
            return view('OrderModule.view_order_list')->with(['user'=> $user, 'product'=> $product]);
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

    public function addOrder()
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
            
            $data = $request->all();
            $all_product = Product::get();
            //add row in Order Information
            $order = new OrderInformation;
            $order->custName = $data['custName'];
            $order->custPhoneNum = $data['custPhoneNum'];
            $order->deliveryAddress = $data['deliveryAddress'];
            $order->paymentMethod = $data['paymentMethod'];
            $order->additionalCost = $data['additionalCost'];
            $order->orderDate = $data['orderDate'];
            foreach($all_product as $dataaa)
            {
                $name = $dataaa->productId . "_restock_qty";
                $restock->$name = $data[$name];
                $total_price += $dataaa->$search * $data[$name];
            }
            $restock->restockPrice = $total_price;
            $restock->employeeId = Auth::id();
            $restock->save();

            return view('OrderModule.add_order')->with(['user'=> $user, 'product'=> $product]);
        }
        return redirect('login');
    }
}
