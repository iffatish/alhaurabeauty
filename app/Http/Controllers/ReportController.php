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
use Illuminate\Support\Facades\DB;

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
                
                if($daily_order->count() != 0){

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

                    $productSold .= $p_o->productName . " (" . $total_product[$i] . ") - RM " . number_format($total_product_price[$i], 2, '.', '');
                    
                    if($i != $last_product){
                        $productSold .= ",";
                    }
                    
                }

                $total_sales = 0;
                //find total sales
                foreach($total_product_price as $price){
                    $total_sales += $price;
                }

                //find capital price
                $user_restock = RestockInformation::where('employeeId',Auth::id())->get();
                $list_column_qty = array();
                foreach($product_list as $k => $p_l)
                {
                    $col = $p_l->productId . "_qty_remainder";
                    $col_price = $p_l->productId . "_restock_price";
                    $list_column_qty[$k] = $col;
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
                
                if($daily_order){
                    //select restock row that remainder all zero to update report status
                    $db_statement = "SELECT * FROM restock_information WHERE ";
                    $lastindex = count($list_column_qty) - 1;
                    foreach($list_column_qty as $m => $l)
                    {
                        $db_statement .= $l . " = 0 ";
                        if($m != $lastindex){
                            $db_statement .= "AND ";
                        }
                    }
                    
                    $result = DB::select($db_statement);
                    $restocks = RestockInformation::hydrate($result);
                    //update status to 1 if all remainder 0 (Have been used in report generated)
                    foreach($restocks as $rstk)
                    {
                        $update = RestockInformation::where('restockId',$rstk->restockId)->update(['status' => 1]);
                    }
                }

                $saved = Report::create([
                                        'employeeId' => Auth::id(),
                                        'salesReportType' => "Daily",
                                        'reportDate' => $current_date_system,
                                        'totalSalesQty' => $daily_order->count(),
                                        'quantitySold' => $total_items,
                                        'productSold' => $productSold,
                                        'totalSales' => $total_sales,
                                        'capital' => $capital,
                                        'profit' => $total_sales - $capital
                                    ]);

                $daily_order_update_status = OrderInformation::where(['orderDate' => $current_date_system,'employeeId' => Auth::id()])->update(['status' => 1]);
                }
                else{
                    
                }

            }else{
                $daily_order = OrderInformation::where([
                    'orderDate' => $current_date_system,
                    'employeeId' => Auth::id(),
                    'status' => 0
                    ])->get(); //
                
                if($daily_order->count() > 0)
                {
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
                        $total_items += $o->totalItems;   //3
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

                        $productSold .= $p_o->productName . " (" . $total_product[$i] . ") - RM " . number_format($total_product_price[$i], 2, '.', '');
                        
                        if($i != $last_product){
                            $productSold .= ",";
                        }

                    }

                    $total_sales = 0;
                    //find total sales
                    foreach($total_product_price as $price){
                        $total_sales += $price;
                    }

                    //find capital price
                    $user_restock = RestockInformation::where(['employeeId' => Auth::id(), 'status' => 0])->get();
                    $list_column_qty = array();
                    foreach($product_list as $k => $p_l)
                    {
                        $col = $p_l->productId . "_qty_remainder";
                        $col_price = $p_l->productId . "_restock_price";
                        $list_column_qty[$k] = $col;
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
                    
                    //select restock row that remainder all zero to update report status
                    $db_statement = "SELECT * FROM restock_information WHERE ";
                    $lastindex = count($list_column_qty) - 1;
                    foreach($list_column_qty as $m => $l)
                    {
                        $db_statement .= $l . " = 0 ";
                        if($m != $lastindex){
                            $db_statement .= "AND ";
                        }
                    }
                    
                    $result = DB::select($db_statement);
                    $restocks = RestockInformation::hydrate($result);
                    //update status to 1 if all remainder 0 (Have been used in report generated)
                    foreach($restocks as $rstk)
                    {
                        $update = RestockInformation::where('restockId',$rstk->restockId)->update(['status' => 1]);
                    }

                    $totalSales = $report->totalSales + $total_sales;
                    $total_capital = $report->capital + $capital;
                    $total_profit = $totalSales - $total_capital;

                    //combine products sold
                    $report_products = array();
                    $update_products = array();
                    $new_productSold = "";
                    $report_products = explode(',', $report->productSold);
                    $update_products = explode(',', $productSold);
                    $lst_i = count($update_products) - 1;

                    foreach($update_products as $num => $a){
                        $new = 1;
                        $current_product = strtok($a, " ");
                        foreach($report_products as $b){
                            $current_report_product = strtok($b, " ");
                            if($current_product == $current_report_product){

                                $name = strtok($b, "(");
                                
                                //quantity
                                //update
                                $str_1_qty = substr($a, strpos($a, "(") + 1);
                                $str_2_qty = strtok($str_1_qty, ")");
                                $update_qty = (int) $str_2_qty;
                                
                                //report
                                $str_3_qty = substr($b, strpos($b, "(") + 1);
                                $str_4_qty = strtok($str_3_qty, ")");
                                $report_qty = (int) $str_4_qty;
                                
                                $new_qty = $report_qty + $update_qty;
                                
                                //price
                                //update
                                $str_5_qty = substr($a, strpos($a, "-") + 5);
                                $update_price = (double) $str_5_qty;
                                
                                //report
                                $str_6_qty = substr($b, strpos($b, "-") + 5);
                                $report_price = (double) $str_6_qty;
                                
                                $new_price = $report_price + $update_price;
                                
                                $new_productSold .= $name . "(" . $new_qty . ") - RM " . number_format($new_price, 2, '.', '');
                                if($num != $lst_i)
                                {
                                    $new_productSold .= ",";
                                }
                                $new = 0;
                                break;
                            }                 
                        }
                        if($new == 1)
                        {
                            $new_productSold .= $a;
                            if($num != $lst_i)
                            {
                                $new_productSold .= ",";
                            }
                        }
                    }

                    $saved = Report::where('reportDate', $current_date_system)
                                    ->update([
                                            'employeeId' => Auth::id(),
                                            'salesReportType' => "Daily",
                                            'reportDate' => $current_date_system,
                                            'totalSalesQty' => $report->totalSalesQty + $daily_order->count(),
                                            'quantitySold' => $report->quantitySold + $total_items,
                                            'productSold' => $new_productSold,
                                            'totalSales' => $totalSales,
                                            'capital' => $total_capital,
                                            'profit' => $total_profit
                                        ]);
                    
                    $daily_order_update_status = OrderInformation::where(['orderDate' => $current_date_system,'employeeId' => Auth::id()])->update(['status' => 1]);
                }
            }

            $report = Report::where('reportDate', $current_date_system)->first();

            return view('ReportModule.view_sales_report')->with(['user'=> $user, 'report' => $report, 'current_date' => $current_date]);
        }
        return redirect('login');
    }
}