<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductQuantity;
use App\Models\OrderInformation;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function viewSalesReport()
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            
            return view('ReportModule.view_sales_report')->with(['user'=> $user]);
        }
        return redirect('login');
    }
}