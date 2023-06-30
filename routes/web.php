<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(UserController::class)->group(function(){

    Route::get('/', 'home')->name('home');

    Route::get('login', 'index')->name('login');

    Route::get('registration', 'registration')->name('registration');

    Route::get('logout', 'logout')->name('logout');

    Route::post('validate_registration', 'validate_registration')->name('user.validate_registration');

    Route::post('validate_login', 'validate_login')->name('user.validate_login');

    Route::get('dashboard', 'dashboard')->name('dashboard');

    Route::get('user_account', 'viewUser')->name('user.account');

    Route::get('update_user', 'viewUpdateUser')->name('update_user');

    Route::post('update_user_save', 'updateUser')->name('user.update');

    Route::post('deactivate_account/{id}', 'deactivateAccount')->name('user.deactivate');

});

Route::controller(ItemController::class)->group(function(){

    Route::get('view_stock', 'viewStock')->name('view_stock');

    Route::get('add_product', 'viewAddProduct')->name('add_product');

    Route::post('add_product_save', 'addProduct')->name('product.add');

    Route::get('update_product', 'viewUpdateProduct')->name('update_product');

    Route::post('update_product_save', 'updateProduct')->name('product.update');

    Route::post('delete_product/{productId}', 'deleteProduct')->name('product.delete');

    Route::get('restock_product', 'viewRestockProduct')->name('restock_product');

    Route::post('add_item_restock_info', 'addItemRestockInfo')->name('add_item_restock_info');

    Route::get('view_restock_list', 'viewRestockList')->name('view_restock_list');

    Route::get('view_restock_details', 'viewRestockDetails')->name('view_restock_details');
    
    Route::get('view_discount', 'viewDiscount')->name('view_discount');

    Route::get('view_update_discount', 'viewUpdateDiscount')->name('view_update_discount');

    Route::post('update_discount', 'updateDiscount')->name('update_discount');

    Route::get('view_product_discount', 'viewProductDiscount')->name('view_product_discount');

    Route::get('view_update_product_discount', 'viewUpdateProductDiscount')->name('view_update_product_discount');

    Route::post('update_product_discount', 'updateProductDiscount')->name('update_product_discount');

});

Route::controller(TeamController::class)->group(function(){

    Route::get('view_team_list', 'viewTeamList')->name('view_team_list');

    Route::get('create_team', 'viewCreateTeam')->name('create_team');

    Route::post('create_team_save', 'createTeam')->name('team.create');

    Route::get('view_team_details', 'viewTeamDetails')->name('view_team_details');

    Route::get('view_team_member', 'viewTeamMember')->name('view_team_member');

    Route::get('update_team', 'viewUpdateTeam')->name('update_team');

    Route::post('update_team_save', 'updateTeam')->name('team.update');

    Route::get('add_team_member', 'viewAddTeamMember')->name('add_team_member');

    Route::post('add_team_member_save', 'addTeamMember')->name('team.add_member');

    Route::post('get-employee','searchEmployee')->name('ajaxSearchEmployee');

    Route::get('view_team_restock', 'viewTeamRestock')->name('view_team_restock');

    Route::get('view_team_restock_graph', 'viewTeamRestockGraph')->name('view_team_restock_graph');

    Route::post('update_team_restock_graph', 'updateChart')->name('update_team_restock_graph');

    Route::post('remove_member/{id}', 'removeTeamMember')->name('remove_member');

    Route::post('leave_team/{teamId}', 'leaveTeam')->name('leave_team');

    Route::post('delete_team/{teamId}', 'deleteTeam')->name('delete_team');

});

Route::controller(OrderController::class)->group(function(){

    Route::get('view_order_list', 'viewOrderList')->name('view_order_list');

    Route::get('add_order', 'viewAddOrder')->name('add_order');
    
    Route::post('add_order_save', 'addOrder')->name('add_order_save');

    Route::post('validate-quantity-stock','validateQuantityStock')->name('ajaxValidateQuantityStock');

    Route::get('view_order_details', 'viewOrderDetails')->name('view_order_details');

});

Route::controller(ReportController::class)->group(function(){

    Route::get('view_sales_report', 'viewSalesReport')->name('view_sales_report');
    
    Route::get('view_monthly_sales_report', 'viewMonthlySalesReport')->name('view_monthly_sales_report');
    
    Route::get('view_yearly_sales_report', 'viewYearlySalesReport')->name('view_yearly_sales_report');

    Route::get('update_monthly_sales_report', 'updateMonthlySalesReport')->name('update_monthly_sales_report');
    
    Route::get('update_yearly_sales_report', 'updateYearlySalesReport')->name('update_yearly_sales_report');
    
    Route::get('view_teammate_sales_report', 'viewTeammateSalesReport')->name('view_teammate_sales_report');

    Route::get('view_monthly_teammate_sales_report', 'viewMonthlyTeammateSalesReport')->name('view_monthly_teammate_sales_report');
    
    Route::get('view_yearly_teammate_sales_report', 'viewYearlyTeammateSalesReport')->name('view_yearly_teammate_sales_report');

    Route::get('update_monthly_teammate_sales_report', 'updateMonthlyTeammateSalesReport')->name('update_monthly_teammate_sales_report');
    
    Route::get('update_yearly_teammate_sales_report', 'updateYearlyTeammateSalesReport')->name('update_yearly_teammate_sales_report');

    Route::get('view_team_sales_report', 'viewTeamSalesReport')->name('view_team_sales_report');

});