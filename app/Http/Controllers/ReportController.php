<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductQuantity;
use App\Models\OrderInformation;
use App\Models\RestockInformation;
use App\Models\Report;
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

            $report = Report::where('reportDate', $current_date_system)->first();

            if(!$report)
            {
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
                $capital = 0;

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

                $productSold = "";
                $last_product = $product_list->count() - 1;
                //Find total for each product
                foreach($product_list as $i => $p_o)
                {
                    $col = $p_o->productId . "_order_qty";
                    $col_price = $p_o->productId . "_order_price";
                    $total_product[$i] = 0;
                    $total_product_price[$i] = 0;

                    foreach($daily_order as $d_o)
                    {
                        $total_product[$i] +=  $d_o->$col;
                        $total_product_price[$i] += $d_o->$col_price * $d_o->$col;
                    }

                    $productSold += $p_o->productName . " (" . $total_product[$i] . ") - RM " . number_format($total_product_price[$i], 2, '.', '');
                    
                    if($i == $last_product){
                        $productSold += ",";
                    }

                }

                $total_sales = 0;
                //find total sales
                foreach($total_product_price as $price){
                    $total_sales += $price;
                }

                //find capital price
                $user_restock = RestockInformation::where('employeeId',Auth::id())->get();

                foreach($product_list as $k => $p_l)
                {
                    $col = $p_l->productId . "_qty_remainder";
                    $col_price = $p_l->productId . "_restock_price";

                    $remainder = 0;
                    foreach($user_restock as $restock)
                    {
                        if(($restock->$col >= $total_product[$k]) && ($remainder == 0)){              

                        $capital += $restock->$col_price * $total_product[$k];

                        RestockInformation::where('restockId',$restock->restockId)
                                            ->update([
                                            $col => $restock->$col - $total_product[$k]
                                            ]);

                        break;
                        }
                        else if(($remainder != 0)  && ($restock->$col >= $remainder)){

                            $capital += $restock->$col_price * $remainder;

                            RestockInformation::where('restockId',$restock->restockId)
                            ->update([
                            $col => $restock->$col - $remainder
                            ]);

                            break;
                        }
                        else{
                            $capital += $restock->$col_price * $restock->$col;

                            RestockInformation::where('restockId',$restock->restockId)
                            ->update([
                            $col => 0
                            ]);

                            $remainder = $total_product[$k] - $restock->$col;
                        }
                    }
                }
                
                $saved = Report::create([
                                        'employeeId' => Auth::id(),
                                        'reportDate' => $current_date_system,
                                        'totalSalesQty' => $daily_order->count(),
                                        'productSold' => $productSold,
                                        'totalSales' => $total_sales,
                                        'capital' => $capital,
                                        'profit' => $total_sales - $capital
                                    ]);
            }
            
            return view('ReportModule.view_sales_report')->with(['user'=> $user, 'report' => $report]);
        }
        return redirect('login');
    }
}