<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductQuantity;
use App\Models\OrderInformation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function viewSalesReport()
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $current_date = Carbon::now()->format('d-m-Y');
            $current_date_system = Carbon::now()->format('Y-m-d');
            $daily_order = OrderInformation::where([
                                                    'orderDate' => $current_date_system,
                                                    'employeeId' => Auth::id()
                                                    ])->get();
            $product = Product::get();

            $total_items = 0;
            $total = 0;
            $total_product = array();
            $total_product_price = array();
            $product_list = collect();
            
            //count total items
            foreach($daily_order as $o)
            {
                
                $total_items += $o->totalItems;   
            }

            //Find list of products ordered
            foreach($product as $p)
            {  
                $col = $p->productId . "_order_qty";
                $total = 0;

                foreach($daily_order as $d_o)
                {
                    $total +=  $d_o->$col;
                }

                if($total != 0)
                {
                    $product_list->push($p);
                }
            }

            //Find total for each product
            foreach($product_list as $i => $p_o)
            {
                $col = $p->productId . "_order_qty";
                $col_price = $p->productId . "_order_price";
                $total_product[$i] = 0;
                $total_product_price[$i] = 0;

                foreach($daily_order as $d_o)
                {
                    $total_product[$i] +=  $d_o->$col;
                    $total_product_price[$i] += $d_o->$col_price;
                }
            }
            
            return view('ReportModule.view_sales_report')->with(['user'=> $user,
                                                                'current_date' => $current_date,
                                                                'daily_order' => $daily_order,
                                                                'total_items' => $total_items,
                                                                'total_product' => $total_product,
                                                                'product_list' => $product_list,
                                                                'total_product_price' => $total_product_price
                                                                ]);
        }
        return redirect('login');
    }
}