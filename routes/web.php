<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\OrderController;

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

Route::get('/', function () {
    return view('UserModule.signin');
});

Route::controller(UserController::class)->group(function(){

    Route::get('login', 'index')->name('login');

    Route::get('registration', 'registration')->name('registration');

    Route::get('logout', 'logout')->name('logout');

    Route::post('validate_registration', 'validate_registration')->name('user.validate_registration');

    Route::post('validate_login', 'validate_login')->name('user.validate_login');

    Route::get('dashboard', 'dashboard')->name('dashboard');

    Route::get('user_account', 'viewUser')->name('user.account');

    Route::get('update_user', 'viewUpdateUser')->name('update_user');

    Route::post('update_user_save', 'updateUser')->name('user.update');

});

Route::controller(ItemController::class)->group(function(){

    Route::get('view_stock', 'viewStock')->name('view_stock');

    Route::get('add_product', 'viewAddProduct')->name('add_product');

    Route::post('add_product_save', 'addProduct')->name('product.add');

    Route::get('update_product', 'viewUpdateProduct')->name('update_product');

    Route::post('update_product_save', 'updateProduct')->name('product.update');

    Route::get('restock_product', 'viewRestockProduct')->name('restock_product');

    Route::post('add_item_restock_info', 'addItemRestockInfo')->name('add_item_restock_info');

    Route::get('view_restock_list', 'viewRestockList')->name('view_restock_list');

    Route::get('view_restock_details', 'viewRestockDetails')->name('view_restock_details');
    
    Route::get('view_discount', 'viewDiscount')->name('view_discount');

    Route::get('view_update_discount', 'viewUpdateDiscount')->name('view_update_discount');

    Route::post('update_discount', 'updateDiscount')->name('update_discount');

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

});

Route::controller(OrderController::class)->group(function(){

    Route::get('view_order_list', 'viewOrderList')->name('view_order_list');

    Route::get('view_order', 'viewOrder')->name('view_order');

    Route::get('add_order', 'viewAddOrder')->name('add_order');
    
    Route::post('add_order_save', 'addOrder')->name('add_order_save');

    Route::post('validate-quantity-stock','validateQuantityStock')->name('ajaxValidateQuantityStock');

    Route::get('view_order_details', 'viewOrderDetails')->name('view_order_details');

});