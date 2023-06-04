<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductQuantity;
use App\Models\OrderInformation;
use App\Models\RestockInformation;
use App\Models\Report;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function createDailySalesReport(Request $request)
    {
        $users = User::get();
        $current_date = Carbon::now()->format('d-m-Y');
        $current_date_system = Carbon::now()->format('Y-m-d');
        
        foreach($users as $user)
        {
            
            $daily_report = Report::where([
                                            'reportDate' => $current_date_system,
                                            'employeeId' => $user->id
                                            ])->first();
            if(!$daily_report){
                
                $daily_order = OrderInformation::where([
                                                        'orderDate' => $current_date_system,
                                                        'employeeId' => $user->id
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

                        foreach($daily_order as $d_)
                        {
                            $total_product[$i] +=  $d_->$col;
                            $total_product_price[$i] += $d_->$col_price * $d_->$col;
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
                    $user_restock = RestockInformation::where('employeeId',$user->id)->get();
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
                        $db_statement = "SELECT * FROM restock_information WHERE employeeId = " . $user->id . " AND ";
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
                                            'employeeId' => $user->id,
                                            'salesReportType' => "Daily",
                                            'reportDate' => $current_date_system,
                                            'totalSalesQty' => $daily_order->count(),
                                            'quantitySold' => $total_items,
                                            'productSold' => $productSold,
                                            'totalSales' => $total_sales,
                                            'capital' => $capital,
                                            'profit' => $total_sales - $capital
                                        ]);

                    $daily_order_update_status = OrderInformation::where(['orderDate' => $current_date_system,'employeeId' => $user->id])->update(['status' => 1]);
                }else{

                    $saved = Report::create([
                        'employeeId' => $user->id,
                        'salesReportType' => "Daily",
                        'reportDate' => $current_date_system,
                    ]);
                }
            }   
        }
    }

    public function createMonthlySalesReport(Request $request)
    {   
        $users = User::get();
        $current_date = Carbon::now()->format('d-m-Y');
        $current_date_system = Carbon::now()->format('Y-m-d');
        
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        
        foreach($users as $user)
        {
            $monthly_report = Report::where(['salesReportType'=>'Monthly', 'employeeId' => $user->id])
                                    ->whereMonth('reportDate', Carbon::now()->month)
                                    ->first();

            if(!$monthly_report){
                $product = Product::get();
                
                $totalSalesQty = 0;
                $total_items = 0;
                $productSold = "";
                $total_sales = 0;
                $capital = 0;
                $profit = 0;

                $daily_reports = Report::where(['salesReportType'=>'Daily', 'employeeId' => $user->id])
                                        ->whereMonth('reportDate', Carbon::now()->month)
                                        ->get();
                    
            foreach($daily_reports as $dr)
                {
                    $totalSalesQty += $dr->totalSalesQty;
                    $total_items += $dr->quantitySold;
                    $total_sales += $dr->totalSales;
                    $capital += $dr->capital;
                    $profit += $dr->profit;  
                }

                $monthly_order = OrderInformation::where('employeeId', $user->id)
                                                    ->whereMonth('orderDate', Carbon::now()->month)
                                                    ->get();
                
                //get list of monthly products ordered
                $product_list = collect();
                
                foreach($product as $p)
                {  
                    $col = $p->productId . "_order_qty";
                    $total = 0;

                    foreach($monthly_order as $m_order)
                    {
                        $total +=  $m_order->$col;
                    }

                    if($total != 0)
                    {
                        $product_list->push($p);
                    }
                }

                $last_product = $product_list->count() - 1;
                $total_product = array();
                $total_product_price = array();

                //Find total for each product
                foreach($product_list as $i => $p_o)
                {
                    $col = $p_o->productId . "_order_qty";
                    $col_price = $p_o->productId . "_order_price";
                    $total_product[$i] = 0;
                    $total_product_price[$i] = 0;

                    foreach($monthly_order as $m_o)
                    {
                        $total_product[$i] +=  $m_o->$col;
                        $total_product_price[$i] += $m_o->$col_price * $m_o->$col;
                    }

                    $productSold .= $p_o->productName . " (" . $total_product[$i] . ") - RM " . number_format($total_product_price[$i], 2, '.', '');
                    
                    if($i != $last_product){
                        $productSold .= ",";
                    }   
                }

                $saved = Report::create([
                                            'employeeId' => $user->id,
                                            'salesReportType' => "Monthly",
                                            'reportDate' => $current_date_system,
                                            'totalSalesQty' => $totalSalesQty,
                                            'quantitySold' => $total_items,
                                            'productSold' => $productSold,
                                            'totalSales' => $total_sales,
                                            'capital' => $capital,
                                            'profit' => $profit]); 
            }
        }
    }

    public function createYearlySalesReport(Request $request)
    {
        $user = User::get();
        $current_date = Carbon::now()->format('d-m-Y');
        $current_date_system = Carbon::now()->format('Y-m-d');
        
        $year = Carbon::now()->year;
            
        foreach($user as $user)
        {
            $yearly_report = Report::where(['salesReportType'=>'Yearly', 'employeeId' => $user->id])
                                    ->whereYear('reportDate', $year)
                                    ->first();

            if(!$yearly_report){

                $product = Product::get();
                
                $totalSalesQty = 0;
                $total_items = 0;
                $productSold = "";
                $total_sales = 0;
                $capital = 0;
                $profit = 0;

                $monthly_reports = Report::where(['salesReportType'=>'Monthly', 'employeeId' => $user->id])
                                        ->whereYear('reportDate', $year)
                                        ->get();
                    
                foreach($monthly_reports as $mr)
                {
                    $totalSalesQty += $mr->totalSalesQty;
                    $total_items += $mr->quantitySold;
                    $total_sales += $mr->totalSales;
                    $capital += $mr->capital;
                    $profit += $mr->profit;  
                }

                $yearly_order = OrderInformation::where('employeeId', $user->id)
                                                    ->whereYear('orderDate', $year)
                                                    ->get();
                
                //get list of yearly products ordered
                $product_list = collect();
                
                foreach($product as $p)
                {  
                    $col = $p->productId . "_order_qty";
                    $total = 0;

                    foreach($yearly_order as $y_order)
                    {
                        $total +=  $y_order->$col;
                    }

                    if($total != 0)
                    {
                        $product_list->push($p);
                    }
                }

                $last_product = $product_list->count() - 1;
                $total_product = array();
                $total_product_price = array();

                //Find total for each product
                foreach($product_list as $i => $p_o)
                {
                    $col = $p_o->productId . "_order_qty";
                    $col_price = $p_o->productId . "_order_price";
                    $total_product[$i] = 0;
                    $total_product_price[$i] = 0;

                    foreach($yearly_order as $y_o)
                    {
                        $total_product[$i] +=  $y_o->$col;
                        $total_product_price[$i] += $y_o->$col_price * $y_o->$col;
                    }

                    $productSold .= $p_o->productName . " (" . $total_product[$i] . ") - RM " . number_format($total_product_price[$i], 2, '.', '');
                    
                    if($i != $last_product){
                        $productSold .= ",";
                    }   
                }

                $saved = Report::create([
                        'employeeId' => $user->id,
                        'salesReportType' => "Yearly",
                        'reportDate' => $current_date_system,
                        'totalSalesQty' => $totalSalesQty,
                        'quantitySold' => $total_items,
                        'productSold' => $productSold,
                        'totalSales' => $total_sales,
                        'capital' => $capital,
                        'profit' => $profit
                    ]);
            }
        }           
    }

    public function viewSalesReport(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $current_date = Carbon::now()->format('d-m-Y');
            $current_date_system = Carbon::now()->format('Y-m-d');
           
            $report = Report::where(['reportDate' => $current_date_system, 'employeeId' => $user->id, 'salesReportType' => "Daily"])->first();

            $daily_order = OrderInformation::where([
                                                    'orderDate' => $current_date_system,
                                                    'employeeId' => Auth::id(),
                                                    'status' => 0
                                                    ])->get();
                
            $daily_order_all = OrderInformation::where([
                                                        'orderDate' => $current_date_system,
                                                        'employeeId' => Auth::id()
                                                        ])->get();
                
            if($daily_order->count() > 0)
            {
                $product = Product::get();

                $total_items = 0;
                $total = 0;
                $total_product = array();
                $total_product_price = array();
                $product_list = collect();
                $total_product_capital = array();
                $product_list_capital = collect();
                $capital = 0;

                //count total items
                foreach($daily_order_all as $o)
                {
                    $total_items += $o->totalItems;    
                }

                //Find list of products ordered
                foreach($product as $p)
                {  
                    $col = $p->productId . "_order_qty";
                    $total = 0;
                    $total_capital = 0;

                    foreach($daily_order_all as $d_o)
                    {
                        $total +=  $d_o->$col;
                    }

                    foreach($daily_order as $d_o_c)
                    {
                        $total_capital +=  $d_o_c->$col;
                    }

                    if($total != 0)
                    {
                        $product_list->push($p);
                        $product_list_capital->push($p);
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

                    foreach($daily_order_all as $d_)
                    {
                        $total_product[$i] +=  $d_->$col;
                        $total_product_price[$i] += $d_->$col_price * $d_->$col;
                    }

                    $productSold .= $p_o->productName . " (" . $total_product[$i] . ") - RM " . number_format($total_product_price[$i], 2, '.', '');
                    
                    if($i != $last_product){
                        $productSold .= ",";
                    }

                }

                foreach($product_list_capital as $u => $p_o_c)
                {
                    $col = $p_o_c->productId . "_order_qty";
                    $col_price = $p_o_c->productId . "_order_price";
                    $total_product_capital[$u] = 0;

                    foreach($daily_order as $dlyorder)
                    {
                        $total_product_capital[$u] +=  $dlyorder->$col;
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
                        if(($restock->$col >= $total_product_capital[$k]) && ($remainder == 0)){              

                        $capital += $restock->$col_price * $total_product_capital[$k];

                        RestockInformation::where('restockId',$restock->restockId)
                                            ->update([
                                            $col => $restock->$col - $total_product_capital[$k]
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

                            $remainder = $total_product_capital[$k] - $restock->$col;
                        }
                    }
                }
                
                //select restock row that remainder all zero to update report status
                $db_statement = "SELECT * FROM restock_information WHERE employeeId = " . Auth::id() . " AND ";
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

                $totalSales = $total_sales;
                $total_capital = $report->capital + $capital;
                $total_profit = $totalSales - $total_capital;

                $saved = Report::where(['reportDate'=> $current_date_system, 'employeeId' => $user->id,'salesReportType' => "Daily"])
                                ->update([
                                        'reportDate' => $current_date_system,
                                        'totalSalesQty' => $daily_order_all->count(),
                                        'quantitySold' => $total_items,
                                        'productSold' => $productSold,
                                        'totalSales' => $totalSales,
                                        'capital' => $total_capital,
                                        'profit' => $total_profit
                                    ]);
                
                $daily_order_update_status = OrderInformation::where(['orderDate' => $current_date_system,'employeeId' => Auth::id()])->update(['status' => 1]);
            }

            $report = Report::where(['reportDate' => $current_date_system, 'employeeId' => $user->id,'salesReportType' => "Daily"])->first();

            return view('ReportModule.view_sales_report')->with(['user'=> $user, 'report' => $report, 'current_date' => $current_date]);
        }
        return redirect('login');
    }

    public function viewMonthlySalesReport(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $current_date = Carbon::now()->format('d-m-Y');
            $current_date_system = Carbon::now()->format('Y-m-d');
            
            $month = Carbon::now()->month;
            $year = Carbon::now()->year;
            
            $monthly_report = Report::where(['salesReportType' => 'Monthly','employeeId' => $user->id])
                                    ->whereYear('reportDate', $year)
                                    ->whereMonth('reportDate', $month)
                                    ->first();
            $product = Product::get();
            
            $totalSalesQty = 0;
            $total_items = 0;
            $productSold = "";
            $total_sales = 0;
            $capital = 0;
            $profit = 0;

            $daily_reports = Report::where(['salesReportType'=>'Daily', 'employeeId' => $user->id])
                                    ->whereMonth('reportDate', Carbon::now()->month)
                                    ->get();
                
            if($daily_reports->count() != 0){
                    
                foreach($daily_reports as $dr)
                {
                    $totalSalesQty += $dr->totalSalesQty;
                    $total_items += $dr->quantitySold;
                    $total_sales += $dr->totalSales;
                    $capital += $dr->capital;
                    $profit += $dr->profit;  
                }

                $monthly_order = OrderInformation::where('employeeId', Auth::id())
                                                    ->whereMonth('orderDate', Carbon::now()->month)
                                                    ->get();
                
                //get list of monthly products ordered
                $product_list = collect();
                
                foreach($product as $p)
                {  
                    $col = $p->productId . "_order_qty";
                    $total = 0;

                    foreach($monthly_order as $m_order)
                    {
                        $total +=  $m_order->$col;
                    }

                    if($total != 0)
                    {
                        $product_list->push($p);
                    }
                }

                $last_product = $product_list->count() - 1;
                $total_product = array();
                $total_product_price = array();

                //Find total for each product
                foreach($product_list as $i => $p_o)
                {
                    $col = $p_o->productId . "_order_qty";
                    $col_price = $p_o->productId . "_order_price";
                    $total_product[$i] = 0;
                    $total_product_price[$i] = 0;

                    foreach($monthly_order as $m_o)
                    {
                        $total_product[$i] +=  $m_o->$col;
                        $total_product_price[$i] += $m_o->$col_price * $m_o->$col;
                    }

                    $productSold .= $p_o->productName . " (" . $total_product[$i] . ") - RM " . number_format($total_product_price[$i], 2, '.', '');
                    
                    if($i != $last_product){
                        $productSold .= ",";
                    }   
                }

                $saved = Report::where(['salesReportType'=>'Monthly', 'employeeId' => $user->id])
                                    ->whereYear('reportDate', $year)
                                    ->whereMonth('reportDate', $month)
                                    ->update([
                                        'reportDate' => $current_date_system,
                                        'totalSalesQty' => $totalSalesQty,
                                        'quantitySold' => $total_items,
                                        'productSold' => $productSold,
                                        'totalSales' => $total_sales,
                                        'capital' => $capital,
                                        'profit' => $profit]);       
            }

            $report = Report::where(['salesReportType' => 'Monthly','employeeId' => $user->id])
                            ->whereYear('reportDate', $year)
                            ->whereMonth('reportDate', $month)
                            ->first();
            
            $month_str =  Carbon::now()->format('F');

            return view('ReportModule.view_monthly_sales_report')->with(['user'=> $user, 'report' => $report, 'month' => $month_str]);
        }
        return redirect('login');
    }

    public function updateMonthlySalesReport(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $current_date = Carbon::now()->format('d-m-Y');
            $month = Carbon::parse($request->year_month)->format('m');
            $year = Carbon::parse($request->year_month)->format('Y');
            
            $report = Report::where(['employeeId'=> $user->id, 'salesReportType'=>'Monthly'])
                            ->whereYear('reportDate', $year)
                            ->whereMonth('reportDate', $month)
                            ->first();
            
            $month_str = Carbon::parse($request->year_month)->format('F');

            return view('ReportModule.view_monthly_sales_report')->with(['user'=> $user, 'report' => $report, 'month' => $month_str]);
        }
        return redirect('login');
    }

    public function viewYearlySalesReport(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $current_date = Carbon::now()->format('d-m-Y');
            $current_date_system = Carbon::now()->format('Y-m-d');
            
            $year = Carbon::now()->year;

            $product = Product::get();
            
            $totalSalesQty = 0;
            $total_items = 0;
            $productSold = "";
            $total_sales = 0;
            $capital = 0;
            $profit = 0;

            $monthly_reports = Report::where(['salesReportType'=>'Monthly', 'employeeId' => $user->id])
                                    ->whereYear('reportDate', $year)
                                    ->get();
                
            if($monthly_reports->count() != 0){
                
                foreach($monthly_reports as $mr)
                {
                    $totalSalesQty += $mr->totalSalesQty;
                    $total_items += $mr->quantitySold;
                    $total_sales += $mr->totalSales;
                    $capital += $mr->capital;
                    $profit += $mr->profit;  
                }

                $yearly_order = OrderInformation::where('employeeId', Auth::id())
                                                    ->whereYear('orderDate', $year)
                                                    ->get();
                
                //get list of yearly products ordered
                $product_list = collect();
                
                foreach($product as $p)
                {  
                    $col = $p->productId . "_order_qty";
                    $total = 0;

                    foreach($yearly_order as $y_order)
                    {
                        $total +=  $y_order->$col;
                    }

                    if($total != 0)
                    {
                        $product_list->push($p);
                    }
                }

                $last_product = $product_list->count() - 1;
                $total_product = array();
                $total_product_price = array();

                //Find total for each product
                foreach($product_list as $i => $p_o)
                {
                    $col = $p_o->productId . "_order_qty";
                    $col_price = $p_o->productId . "_order_price";
                    $total_product[$i] = 0;
                    $total_product_price[$i] = 0;

                    foreach($yearly_order as $y_o)
                    {
                        $total_product[$i] +=  $y_o->$col;
                        $total_product_price[$i] += $y_o->$col_price * $y_o->$col;
                    }

                    $productSold .= $p_o->productName . " (" . $total_product[$i] . ") - RM " . number_format($total_product_price[$i], 2, '.', '');
                    
                    if($i != $last_product){
                        $productSold .= ",";
                    }   
                }

                
                $saved = Report::where(['salesReportType'=>'Yearly', 'employeeId' => $user->id])
                                    ->whereYear('reportDate', $year)
                                    ->update([
                                        'reportDate' => $current_date_system,
                                        'totalSalesQty' => $totalSalesQty,
                                        'quantitySold' => $total_items,
                                        'productSold' => $productSold,
                                        'totalSales' => $total_sales,
                                        'capital' => $capital,
                                        'profit' => $profit
                                    ]);
            }

            $report = Report::where(['salesReportType' => 'Yearly','employeeId' => $user->id])
                            ->whereYear('reportDate', $year)
                            ->first();

            return view('ReportModule.view_yearly_sales_report')->with(['user'=> $user, 'report' => $report, 'year' => $year]);
        }
        return redirect('login');
    }

    public function updateYearlySalesReport(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            
            $report = Report::where(['employeeId'=> $user->id, 'salesReportType'=>'Yearly'])
                            ->whereYear('reportDate', $request->year_selected)
                            ->first();
            
            return view('ReportModule.view_yearly_sales_report')->with(['user'=> $user, 'report' => $report, 'year' => $request->year_selected]);
        }
        return redirect('login');
    }

    public function viewTeammateSalesReport(Request $request)
    {
        if(Auth::check())
        {
            $teammate = User::where('id', $request->teamMemberId)->first();
            $user = User::where('id', Auth::id())->first();
            $teamId = $request->teamId;
            $teamMemberId = $request->teamMemberId;
            $current_date = Carbon::now()->format('d-m-Y');
            $current_date_system = Carbon::now()->format('Y-m-d');
            
            $daily_order = OrderInformation::where([
                'orderDate' => $current_date_system,
                'employeeId' => $teammate->id,
                'status' => 0
                ])->get();
            
            $daily_order_all = OrderInformation::where([
                'orderDate' => $current_date_system,
                'employeeId' => $teammate->id
                ])->get();
            
            if($daily_order->count() > 0)
            {
                $product = Product::get();

                $total_items = 0;
                $total = 0;
                $total_product = array();
                $total_product_price = array();
                $product_list = collect();
                $total_product_capital = array();
                $product_list_capital = collect();
                $capital = 0;

                //count total items
                foreach($daily_order_all as $o)
                {
                    $total_items += $o->totalItems;    
                }

                //Find list of products ordered
                foreach($product as $p)
                {  
                    $col = $p->productId . "_order_qty";
                    $total = 0;
                    $total_capital = 0;

                    foreach($daily_order_all as $d_o)
                    {
                        $total +=  $d_o->$col;
                    }

                    foreach($daily_order as $d_o_c)
                    {
                        $total_capital +=  $d_o_c->$col;
                    }

                    if($total != 0)
                    {
                        $product_list->push($p);
                        $product_list_capital->push($p);
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

                    foreach($daily_order_all as $d_)
                    {
                        $total_product[$i] +=  $d_->$col;
                        $total_product_price[$i] += $d_->$col_price * $d_->$col;
                    }

                    $productSold .= $p_o->productName . " (" . $total_product[$i] . ") - RM " . number_format($total_product_price[$i], 2, '.', '');
                    
                    if($i != $last_product){
                        $productSold .= ",";
                    }

                }

                foreach($product_list_capital as $u => $p_o_c)
                {
                    $col = $p_o_c->productId . "_order_qty";
                    $col_price = $p_o_c->productId . "_order_price";
                    $total_product_capital[$u] = 0;

                    foreach($daily_order as $dlyorder)
                    {
                        $total_product_capital[$u] +=  $dlyorder->$col;
                    }
                }

                $total_sales = 0;
                //find total sales
                foreach($total_product_price as $price){
                    $total_sales += $price;
                }

                //find capital price
                $user_restock = RestockInformation::where(['employeeId' => $teammate->id, 'status' => 0])->get();
                $list_column_qty = array();
                foreach($product_list as $k => $p_l)
                {
                    $col = $p_l->productId . "_qty_remainder";
                    $col_price = $p_l->productId . "_restock_price";
                    $list_column_qty[$k] = $col;
                    $remainder = 0;
                    foreach($user_restock as $restock)
                    {
                        if(($restock->$col >= $total_product_capital[$k]) && ($remainder == 0)){              

                        $capital += $restock->$col_price * $total_product_capital[$k];

                        RestockInformation::where('restockId',$restock->restockId)
                                            ->update([
                                            $col => $restock->$col - $total_product_capital[$k]
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

                            $remainder = $total_product_capital[$k] - $restock->$col;
                        }
                    }
                }
                
                //select restock row that remainder all zero to update report status
                $db_statement = "SELECT * FROM restock_information WHERE employeeId = " . $teammate->id . " AND ";
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

                $totalSales = $total_sales;
                $total_capital = $report->capital + $capital;
                $total_profit = $totalSales - $total_capital;

                $saved = Report::where(['reportDate'=> $current_date_system, 'employeeId' => $teammate->id,'salesReportType' => "Daily"])
                                ->update([
                                        'reportDate' => $current_date_system,
                                        'totalSalesQty' => $daily_order_all->count(),
                                        'quantitySold' => $total_items,
                                        'productSold' => $productSold,
                                        'totalSales' => $totalSales,
                                        'capital' => $total_capital,
                                        'profit' => $total_profit
                                    ]);
                
                $daily_order_update_status = OrderInformation::where(['orderDate' => $current_date_system,'employeeId' => $teammate->id])->update(['status' => 1]);
            }

            $report = Report::where(['reportDate' => $current_date_system, 'employeeId' => $teammate->id,'salesReportType' => "Daily"])->first();

            return view('ReportModule.view_teammate_sales_report')->with(['user'=> $user, 'report' => $report, 'current_date' => $current_date, 'teamId' => $teamId, 'teamMemberId' => $teamMemberId, 'teammate' => $teammate]);
        }
        return redirect('login');
    }

    public function viewMonthlyTeammateSalesReport(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $teammate = User::where('id', $request->teamMemberId)->first();
            $teamId = $request->teamId;
            $teamMemberId = $request->teamMemberId;
            $current_date = Carbon::now()->format('d-m-Y');
            $current_date_system = Carbon::now()->format('Y-m-d');
            
            $month = Carbon::now()->month;
            $year = Carbon::now()->year;
            
            $product = Product::get();
            
            $totalSalesQty = 0;
            $total_items = 0;
            $productSold = "";
            $total_sales = 0;
            $capital = 0;
            $profit = 0;

            $daily_reports = Report::where(['salesReportType'=>'Daily', 'employeeId' => $teammate->id])
                                    ->whereMonth('reportDate', Carbon::now()->month)
                                    ->get();
                
            if($daily_reports->count() != 0){
                    
                foreach($daily_reports as $dr)
                {
                    $totalSalesQty += $dr->totalSalesQty;
                    $total_items += $dr->quantitySold;
                    $total_sales += $dr->totalSales;
                    $capital += $dr->capital;
                    $profit += $dr->profit;  
                }

                $monthly_order = OrderInformation::where('employeeId', $teammate->id)
                                                    ->whereMonth('orderDate', Carbon::now()->month)
                                                    ->get();
                
                //get list of monthly products ordered
                $product_list = collect();
                
                foreach($product as $p)
                {  
                    $col = $p->productId . "_order_qty";
                    $total = 0;

                    foreach($monthly_order as $m_order)
                    {
                        $total +=  $m_order->$col;
                    }

                    if($total != 0)
                    {
                        $product_list->push($p);
                    }
                }

                $last_product = $product_list->count() - 1;
                $total_product = array();
                $total_product_price = array();

                //Find total for each product
                foreach($product_list as $i => $p_o)
                {
                    $col = $p_o->productId . "_order_qty";
                    $col_price = $p_o->productId . "_order_price";
                    $total_product[$i] = 0;
                    $total_product_price[$i] = 0;

                    foreach($monthly_order as $m_o)
                    {
                        $total_product[$i] +=  $m_o->$col;
                        $total_product_price[$i] += $m_o->$col_price * $m_o->$col;
                    }

                    $productSold .= $p_o->productName . " (" . $total_product[$i] . ") - RM " . number_format($total_product_price[$i], 2, '.', '');
                    
                    if($i != $last_product){
                        $productSold .= ",";
                    }   
                }

                $saved = Report::where(['salesReportType'=>'Monthly', 'employeeId' => $teammate->id])
                                    ->whereYear('reportDate', $year)
                                    ->whereMonth('reportDate', $month)
                                    ->update([
                                        'reportDate' => $current_date_system,
                                        'totalSalesQty' => $totalSalesQty,
                                        'quantitySold' => $total_items,
                                        'productSold' => $productSold,
                                        'totalSales' => $total_sales,
                                        'capital' => $capital,
                                        'profit' => $profit]);     
            }

            $report = Report::where(['salesReportType' => 'Monthly','employeeId' => $teammate->id])
                            ->whereYear('reportDate', $year)
                            ->whereMonth('reportDate', $month)
                            ->first();
            
            $month_str =  Carbon::now()->format('F');

            return view('ReportModule.view_monthly_teammate_sales_report')->with(['user'=> $user, 'report' => $report, 'month' => $month_str, 'teamId' => $teamId, 'teamMemberId' => $teamMemberId, 'teammate' => $teammate]);
        }
        return redirect('login');
    }

    public function updateMonthlyTeammateSalesReport(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $teammate = User::where('id', $request->teamMemberId)->first();
            $teamId = $request->teamId;
            $teamMemberId = $request->teamMemberId;
            $current_date = Carbon::now()->format('d-m-Y');
            $month = Carbon::parse($request->year_month)->format('m');
            $year = Carbon::parse($request->year_month)->format('Y');
            
            $report = Report::where(['employeeId'=> $teammate->id, 'salesReportType'=>'Monthly'])
                            ->whereYear('reportDate', $year)
                            ->whereMonth('reportDate', $month)
                            ->first();
            
            $month_str = Carbon::parse($request->year_month)->format('F');

            return view('ReportModule.view_monthly_teammate_sales_report')->with(['user'=> $user, 'report' => $report, 'month' => $month_str, 'teamId' => $teamId, 'teamMemberId' => $teamMemberId, 'teammate' => $teammate]);
        }
        return redirect('login');
    }

    public function viewYearlyTeammateSalesReport(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $teammate = User::where('id', $request->teamMemberId)->first();
            $teamId = $request->teamId;
            $teamMemberId = $request->teamMemberId;
            $current_date = Carbon::now()->format('d-m-Y');
            $current_date_system = Carbon::now()->format('Y-m-d');
            
            $year = Carbon::now()->year;
            
            $product = Product::get();
            
            $totalSalesQty = 0;
            $total_items = 0;
            $productSold = "";
            $total_sales = 0;
            $capital = 0;
            $profit = 0;

            $monthly_reports = Report::where(['salesReportType'=>'Monthly', 'employeeId' => $teammate->id])
                                    ->whereYear('reportDate', $year)
                                    ->get();
                
            if($monthly_reports->count() != 0){
                
                foreach($monthly_reports as $mr)
                {
                    $totalSalesQty += $mr->totalSalesQty;
                    $total_items += $mr->quantitySold;
                    $total_sales += $mr->totalSales;
                    $capital += $mr->capital;
                    $profit += $mr->profit;  
                }

                $yearly_order = OrderInformation::where('employeeId', $teammate->id)
                                                    ->whereYear('orderDate', $year)
                                                    ->get();
                
                //get list of yearly products ordered
                $product_list = collect();
                
                foreach($product as $p)
                {  
                    $col = $p->productId . "_order_qty";
                    $total = 0;

                    foreach($yearly_order as $y_order)
                    {
                        $total +=  $y_order->$col;
                    }

                    if($total != 0)
                    {
                        $product_list->push($p);
                    }
                }

                $last_product = $product_list->count() - 1;
                $total_product = array();
                $total_product_price = array();

                //Find total for each product
                foreach($product_list as $i => $p_o)
                {
                    $col = $p_o->productId . "_order_qty";
                    $col_price = $p_o->productId . "_order_price";
                    $total_product[$i] = 0;
                    $total_product_price[$i] = 0;

                    foreach($yearly_order as $y_o)
                    {
                        $total_product[$i] +=  $y_o->$col;
                        $total_product_price[$i] += $y_o->$col_price * $y_o->$col;
                    }

                    $productSold .= $p_o->productName . " (" . $total_product[$i] . ") - RM " . number_format($total_product_price[$i], 2, '.', '');
                    
                    if($i != $last_product){
                        $productSold .= ",";
                    }   
                }

                $saved = Report::where(['salesReportType'=>'Yearly', 'employeeId' => $teammate->id])
                                        ->whereYear('reportDate', $year)
                                        ->update([
                                            'reportDate' => $current_date_system,
                                            'totalSalesQty' => $totalSalesQty,
                                            'quantitySold' => $total_items,
                                            'productSold' => $productSold,
                                            'totalSales' => $total_sales,
                                            'capital' => $capital,
                                            'profit' => $profit
                                        ]);
            }

            $report = Report::where(['salesReportType' => 'Yearly','employeeId' => $teammate->id])
                            ->whereYear('reportDate', $year)
                            ->first();

            return view('ReportModule.view_yearly_teammate_sales_report')->with(['user'=> $user, 'report' => $report, 'year' => $year, 'teamId' => $teamId, 'teamMemberId' => $teamMemberId, 'teammate' => $teammate]);
        }
        return redirect('login');
    }

    public function updateYearlyTeammateSalesReport(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $teammate = User::where('id', $request->teamMemberId)->first();
            $teamId = $request->teamId;
            $teamMemberId = $request->teamMemberId;
            
            $report = Report::where(['employeeId'=> $teammate->id, 'salesReportType'=>'Yearly'])
                            ->whereYear('reportDate', $request->year_selected)
                            ->first();
            
            return view('ReportModule.view_yearly_teammate_sales_report')->with(['user'=> $user, 'report' => $report, 'year' => $request->year_selected, 'teamId' => $teamId, 'teamMemberId' => $teamMemberId, 'teammate' => $teammate]);
        }
        return redirect('login');
    }

    public function viewTeamSalesReport(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $teams = Team::get();


            foreach($teams as $team)
            {
                
            }

            return view('ReportModule.view_team_sales_report')->with(['user'=> $user,'teams'=> $teams]);
        }
        return redirect('login');
    }

}
