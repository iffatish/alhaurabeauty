<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductQuantity;
use App\Models\RestockInformation;
use App\Models\PositionDiscount;
use App\Models\ProductDiscount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    //A function to display all active products with the current stock quantity of the logged in user
    public function viewStock()
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $product = Product::where('status_data', 1)->get();
            $user_stock = ProductQuantity::where('employeeId', Auth::id())->first();
            $product_discount = ProductDiscount::where('status',1)->first();
            
            return view('ItemManagementModule.view_stock')->with(['user'=> $user, 'product'=> $product, 'user_stock' => $user_stock, 'product_discount' => $product_discount]);
        }
        return redirect('login');
    }

    //A function to navigate user to the page to add new product
    public function viewAddProduct()
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            
            return view('ItemManagementModule.add_new_product')->with('user', $user);
        }
        return redirect('login');
    }

    //A function to add new product into the system database
    public function addProduct(Request $request)
    {
        if(Auth::check())
        {
            $request->validate([
                'productName' => 'required',
                'productImage' => 'required',
                'productSellPrice' => 'required'
            ]);
    
            $data = $request->all();
            $imageName = time().'.'.$request->productImage->extension();
            $request->productImage->move(public_path('images/products'), $imageName);

            $pos_discount = PositionDiscount::first();

            if($pos_discount)
            {
                $priceHQ = $data['productSellPrice'] - ($data['productSellPrice'] * ($pos_discount->discountHQ / 100));
                $priceMasterLeader = $data['productSellPrice'] - ($data['productSellPrice'] * ($pos_discount->discountMasterLeader / 100));
                $priceLeader = $data['productSellPrice'] - ($data['productSellPrice'] * ($pos_discount->discountLeader / 100));
                $priceMasterStockist = $data['productSellPrice'] - ($data['productSellPrice'] * ($pos_discount->discountMasterStockist / 100));
                $priceStockist = $data['productSellPrice'] - ($data['productSellPrice'] * ($pos_discount->discountStockist / 100));
                $priceMasterAgent = $data['productSellPrice'] - ($data['productSellPrice'] * ($pos_discount->discountMasterAgent / 100));
                $priceAgent = $data['productSellPrice'] - ($data['productSellPrice'] * ($pos_discount->discountAgent / 100));
                $priceDropship = $data['productSellPrice'] - ($data['productSellPrice'] * ($pos_discount->discountDropship / 100));
            }

            $active_discount = ProductDiscount::where('status',1)->first();

            if($active_discount)
            {
                $priceDiscount = $data['productSellPrice'] - ($data['productSellPrice'] * ($active_discount->productDiscount/ 100));
            }

            if($pos_discount && $active_discount){

               Product::create([
                    'productName' => $data['productName'],
                    'productImage' => $imageName,
                    'productSellPrice' => $data['productSellPrice'],
                    'priceHQ' => $priceHQ,
                    'priceMasterLeader' => $priceMasterLeader,
                    'priceLeader' => $priceLeader,
                    'priceMasterStockist' => $priceMasterStockist,
                    'priceStockist' => $priceStockist,
                    'priceMasterAgent' => $priceMasterAgent,
                    'priceAgent' => $priceAgent,
                    'priceDropship' => $priceDropship,
                    'productDiscountPrice' => $priceDiscount
                ]); 

            }else if($pos_discount && !($active_discount)){

                Product::create([
                    'productName' => $data['productName'],
                    'productImage' => $imageName,
                    'productSellPrice' => $data['productSellPrice'],
                    'priceHQ' => $priceHQ,
                    'priceMasterLeader' => $priceMasterLeader,
                    'priceLeader' => $priceLeader,
                    'priceMasterStockist' => $priceMasterStockist,
                    'priceStockist' => $priceStockist,
                    'priceMasterAgent' => $priceMasterAgent,
                    'priceAgent' => $priceAgent,
                    'priceDropship' => $priceDropship
                ]);

            }else if(!($pos_discount) && $active_discount){
                
                Product::create([
                    'productName' => $data['productName'],
                    'productImage' => $imageName,
                    'productSellPrice' => $data['productSellPrice'],
                    'priceHQ' => $data['productSellPrice'],
                    'priceMasterLeader' => $data['productSellPrice'],
                    'priceLeader' => $data['productSellPrice'],
                    'priceMasterStockist' => $data['productSellPrice'],
                    'priceStockist' => $data['productSellPrice'],
                    'priceMasterAgent' => $data['productSellPrice'],
                    'priceAgent' => $data['productSellPrice'],
                    'priceDropship' => $data['productSellPrice'],
                    'productDiscountPrice' => $priceDiscount
                ]);

            }else{

                Product::create([
                    'productName' => $data['productName'],
                    'productImage' => $imageName,
                    'productSellPrice' => $data['productSellPrice'],
                    'priceHQ' => $data['productSellPrice'],
                    'priceMasterLeader' => $data['productSellPrice'],
                    'priceLeader' => $data['productSellPrice'],
                    'priceMasterStockist' => $data['productSellPrice'],
                    'priceStockist' => $data['productSellPrice'],
                    'priceMasterAgent' => $data['productSellPrice'],
                    'priceAgent' => $data['productSellPrice'],
                    'priceDropship' => $data['productSellPrice']
                ]);
            }
            

            //Add column in product_quantity table
            $new_product = Product::where('productName', $data['productName'])->first();
            $statement = "ALTER TABLE product_quantity ADD ".$new_product->productId."_qty INT DEFAULT 0";
            DB::statement($statement);

            //Add column in restock_information table
            $statementt = "ALTER TABLE restock_information ADD ".$new_product->productId."_restock_qty INT DEFAULT 0";
            DB::statement($statementt);
            $statementt_1 = "ALTER TABLE restock_information ADD ".$new_product->productId."_restock_price DOUBLE DEFAULT 0";
            DB::statement($statementt_1);
            $statementt_1 = "ALTER TABLE restock_information ADD ".$new_product->productId."_qty_remainder DOUBLE DEFAULT 0";
            DB::statement($statementt_1);

            //Add column in order table
            $statementtt = "ALTER TABLE order_information ADD ".$new_product->productId."_order_qty INT DEFAULT 0";
            DB::statement($statementtt);
            $statementtt_1 = "ALTER TABLE order_information ADD ".$new_product->productId."_order_price DOUBLE DEFAULT 0";
            DB::statement($statementtt_1);

            $user = User::where('id', Auth::id())->first();
            $product = Product::get();
            $user_stock = ProductQuantity::where('employeeId', Auth::id())->first();

            return redirect('view_stock')->with(['user'=> $user, 'product'=> $product, 'user_stock' => $user_stock, 'success' => 'New product successfully added!', 'product_discount' => $active_discount]);
        }
        return redirect('login');
    }

    //A function to navigate user to the page to update product
    public function viewUpdateProduct(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $product = Product::where('productId', $request->productId)->first();
            
            return view('ItemManagementModule.update_product')->with(['user'=> $user, 'product'=> $product]);
        }
        return redirect('login');
    }
  
    //A function to update product information
    function updateProduct(Request $request)
    {
        if(Auth::check())
        {
            $request->validate([
                'productName' => 'required',
                'productSellPrice' => 'required',
            ]);
    
            $data = $request->all();

            $item = Product::where('productId', $request->productId)->first();
            $position_discount = PositionDiscount::first();
            $active_discount = ProductDiscount::where('status',1)->first();

            if($request->productImage){

                $imageName = time().'.'.$request->productImage->extension();
                $request->productImage->move(public_path('images/products'), $imageName);

                if($position_discount && $active_discount){

                    $saved = Product::where('productId', $request->productId)
                        ->update([
                            'productName' => $request->productName,
                            'productImage' => $imageName,
                            'productSellPrice' => $request->productSellPrice,
                            'priceHQ' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountHQ/ 100)),
                            'priceMasterLeader' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountMasterLeader/ 100)),
                            'priceLeader' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountLeader/ 100)),
                            'priceMasterStockist' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountMasterStockist/ 100)),
                            'priceStockist' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountStockist/ 100)),
                            'priceMasterAgent' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountMasterAgent/ 100)),
                            'priceAgent' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountAgent/ 100)), 
                            'priceDropship' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountDropship/ 100)),
                            'productDiscountPrice' => $request->productSellPrice - ($request->productSellPrice * ($active_discount->productDiscount/ 100))
                        ]);

                }else if($position_discount && !($active_discount)){

                    $saved = Product::where('productId', $request->productId)
                        ->update([
                            'productName' => $request->productName,
                            'productImage' => $imageName,
                            'productSellPrice' => $request->productSellPrice,
                            'priceHQ' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountHQ/ 100)),
                            'priceMasterLeader' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountMasterLeader/ 100)),
                            'priceLeader' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountLeader/ 100)),
                            'priceMasterStockist' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountMasterStockist/ 100)),
                            'priceStockist' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountStockist/ 100)),
                            'priceMasterAgent' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountMasterAgent/ 100)),
                            'priceAgent' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountAgent/ 100)), 
                            'priceDropship' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountDropship/ 100)),
                            'productDiscountPrice' => 0
                        ]);

                }else if(!($position_discount) && $active_discount){

                    $saved = Product::where('productId', $request->productId)
                        ->update([
                            'productName' => $request->productName,
                            'productImage' => $imageName,
                            'productSellPrice' => $request->productSellPrice,
                            'priceHQ' => $request->productSellPrice,
                            'priceMasterLeader' => $request->productSellPrice,
                            'priceLeader' => $request->productSellPrice,
                            'priceMasterStockist' => $request->productSellPrice,
                            'priceStockist' => $request->productSellPrice,
                            'priceMasterAgent' => $request->productSellPrice,
                            'priceAgent' => $request->productSellPrice, 
                            'priceDropship' => $request->productSellPrice,
                            'productDiscountPrice' => $request->productSellPrice - ($request->productSellPrice * ($active_discount->productDiscount/ 100))
                        ]);

                }else{
                    
                    $saved = Product::where('productId', $request->productId)
                    ->update([
                        'productName' => $request->productName,
                        'productImage' => $imageName,
                        'productSellPrice' => $request->productSellPrice,
                        'priceHQ' => $request->productSellPrice,
                        'priceMasterLeader' => $request->productSellPrice,
                        'priceLeader' => $request->productSellPrice,
                        'priceMasterStockist' => $request->productSellPrice,
                        'priceStockist' => $request->productSellPrice,
                        'priceMasterAgent' => $request->productSellPrice,
                        'priceAgent' => $request->productSellPrice, 
                        'priceDropship' => $request->productSellPrice,
                        'productDiscountPrice' => 0
                    ]);

                }
            }else{

                if($position_discount && $active_discount){

                    $saved = Product::where('productId', $request->productId)
                        ->update([
                            'productName' => $request->productName,
                            'productSellPrice' => $request->productSellPrice,
                            'priceHQ' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountHQ/ 100)),
                            'priceMasterLeader' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountMasterLeader/ 100)),
                            'priceLeader' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountLeader/ 100)),
                            'priceMasterStockist' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountMasterStockist/ 100)),
                            'priceStockist' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountStockist/ 100)),
                            'priceMasterAgent' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountMasterAgent/ 100)),
                            'priceAgent' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountAgent/ 100)), 
                            'priceDropship' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountDropship/ 100)),
                            'productDiscountPrice' => $request->productSellPrice - ($request->productSellPrice * ($active_discount->productDiscount/ 100))
                        ]);

                }else if($position_discount && !($active_discount)){

                    $saved = Product::where('productId', $request->productId)
                        ->update([
                            'productName' => $request->productName,
                            'productSellPrice' => $request->productSellPrice,
                            'priceHQ' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountHQ/ 100)),
                            'priceMasterLeader' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountMasterLeader/ 100)),
                            'priceLeader' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountLeader/ 100)),
                            'priceMasterStockist' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountMasterStockist/ 100)),
                            'priceStockist' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountStockist/ 100)),
                            'priceMasterAgent' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountMasterAgent/ 100)),
                            'priceAgent' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountAgent/ 100)), 
                            'priceDropship' => $request->productSellPrice - ($request->productSellPrice * ($position_discount->discountDropship/ 100)),
                            'productDiscountPrice' => 0
                        ]);

                }else if(!($position_discount) && $active_discount){

                    $saved = Product::where('productId', $request->productId)
                        ->update([
                            'productName' => $request->productName,
                            'productSellPrice' => $request->productSellPrice,
                            'priceHQ' => $request->productSellPrice,
                            'priceMasterLeader' => $request->productSellPrice,
                            'priceLeader' => $request->productSellPrice,
                            'priceMasterStockist' => $request->productSellPrice,
                            'priceStockist' => $request->productSellPrice,
                            'priceMasterAgent' => $request->productSellPrice,
                            'priceAgent' => $request->productSellPrice, 
                            'priceDropship' => $request->productSellPrice,
                            'productDiscountPrice' => $request->productSellPrice - ($request->productSellPrice * ($active_discount->productDiscount/ 100))
                        ]);

                }else{
                    
                    $saved = Product::where('productId', $request->productId)
                    ->update([
                        'productName' => $request->productName,
                        'productSellPrice' => $request->productSellPrice,
                        'priceHQ' => $request->productSellPrice,
                        'priceMasterLeader' => $request->productSellPrice,
                        'priceLeader' => $request->productSellPrice,
                        'priceMasterStockist' => $request->productSellPrice,
                        'priceStockist' => $request->productSellPrice,
                        'priceMasterAgent' => $request->productSellPrice,
                        'priceAgent' => $request->productSellPrice, 
                        'priceDropship' => $request->productSellPrice,
                        'productDiscountPrice' => 0
                    ]);

                }
            }

            $user = User::where('id', Auth::id())->first();
            $product = Product::where('status_data', 1)->get();

            if($saved){
                return redirect()->route('view_stock')->with('success', 'Product successfully updated!');
            }else{
                return redirect()->route('update_product', ['productId' => $item->productId])->with(['user'=> $user, 'product' => $product]);
            }
        }
        return redirect('login');
    }

    //A function to delete selected product by changing the status data from 1 to 0
    public function deleteProduct(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $product = Product::where('status_data', 1)->get();

            $saved = Product::where('productId', $request->productId)
                        ->update([
                            'status_data' => 0
                        ]);

            // check data deleted or not
            if ($saved) {
                $success = true;
                $message = "Product deleted successfully";
            } else {
                $success = true;
                $message = "Product not found";
            }

            //  return response
            return response()->json([
                'success' => $success,
                'message' => $message,
            ]);
            
        }
        return redirect('login');
    }

    //A function to navigate user to the page to restock product
    public function viewRestockProduct()
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $product = Product::where('status_data', 1)->get();
            
            return view('ItemManagementModule.restock_product')->with(['user'=> $user, 'product'=> $product]);
        }
        return redirect('login');
    }

    //A function to restock product and save the restock information in database
    public function addItemRestockInfo(Request $request)
    {
        if(Auth::check())
        {
            //validate input data
            $request->validate([
                'batchNo' => 'required',
                'restockFrom' => 'required',
                'restockPaymentMethod' => 'required',
                'restockDate' => 'required',
            ]);

            $data = $request->all();
    
            $all_product = Product::where('status_data',1)->get();
            $position = User::where('id', Auth::id())->value('userPosition');
            $product_quantity = ProductQuantity::where('employeeId', Auth::id())->first();

            //find the column name of user's position restock price
            $split_position = preg_split("/[\s,]+/", $position);
            $capitalize_word = array();
            $total_price = 0;
            foreach($split_position as $dataa)
            {
                array_push($capitalize_word,ucfirst($dataa));
            }

            $search = "price";

            foreach($capitalize_word as $d)
            {
                $search .= $d; 
            }
            
            //add row in Restock Information table
            $restock = new RestockInformation;
            $restock->batchNo = $request->batchNo;
            $restock->restockFrom = $request->restockFrom;
            $restock->restockPaymentMethod = $request->restockPaymentMethod;
            $restock->restockDate = $request->restockDate;
            foreach($all_product as $dataaa)
            {
                $product_qty = $dataaa->productId . "_restock_qty";
                $product_price = $dataaa->productId . "_restock_price";
                $product_remainder = $dataaa->productId . "_qty_remainder";
                $restock->$product_qty = $data[$product_qty];
                $restock->$product_price = $dataaa->$search;
                $total_price += $dataaa->$search * $data[$product_qty];
                $restock->$product_remainder = $data[$product_qty];
            }
            $restock->restockPrice = $total_price;
            $restock->currentPosition = $position;
            $restock->employeeId = Auth::id();
            $restock->save();

            //update Product Quantity table for current user
            $product_qty_user = ProductQuantity::where('employeeId', Auth::id())->first();
            foreach($all_product as $dt)
            {
                $name = $dt->productId . "_restock_qty";
                $column = $dt->productId . "_qty";
                $product_quantity = ProductQuantity::where('employeeId', Auth::id())->value($column);
                $total = $product_quantity + $data[$name];

                $product_qty_user->$column = $total;
                
            }
            $product_qty_user->save();

            //get all values needed for the view stock page
            $user = User::where('id', Auth::id())->first();
            $product = Product::where('status_data',1)->get();
            $user_stock = ProductQuantity::where('employeeId', Auth::id())->first();
            $product_discount = ProductDiscount::where('status',1)->first();

            return redirect('view_stock')->with([
                                                'user'=> $user, 
                                                'product'=> $product,
                                                'user_stock' => $user_stock, 
                                                'success' => 'Product successfully restocked!', 
                                                'product_discount' => $product_discount]);
        }
        return redirect('login');
    }

    //A function to navigate user to the page to view restock information list
    public function viewRestockList()
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $restock = RestockInformation::where('employeeId', Auth::id())->orderBy('restockDate', 'DESC')->get();
            $product = Product::get();

            //count total quantity restock
            $total_items = array();
            foreach($restock as $r)
            {
                $total = 0;
                foreach($product as $data)
                {
                    $col = $data->productId . "_restock_qty";
                    $total += $r->$col;
                }
                array_push($total_items , $total);
            }
            
            return view('ItemManagementModule.view_restock_list')->with(['user'=> $user, 'restock'=> $restock, 'total_items' => $total_items]);
        }
        return redirect('login');
    }

    //A function to display restock information details
    public function viewRestockDetails(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $restock = RestockInformation::where('restockId', $request->restockId)->first();
            $product = Product::get();

            $total_items = 0;
            $product_restock = collect();
            foreach($product as $data)
            {
                $col = $data->productId . "_restock_qty";
                $total_items += $restock->$col;

                if($restock->$col != 0){
                    $product_restock->push($data);
                }
            }

            return view('ItemManagementModule.view_restock_details')->with([
                'user'=> $user, 
                'restock'=> $restock, 
                'total_items' => $total_items,
                'product_restock' => $product_restock
            ]);
        }
        return redirect('login');
    }

    //A function to display position discount page
    public function viewDiscount(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $discount = PositionDiscount::first();
            
            return view('ItemManagementModule.view_discount')->with(['user'=> $user,'discount'=> $discount]);
        }
        return redirect('login');
    }

    //A function to navigate user to the page to update position discount
    public function viewUpdateDiscount(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $discount = PositionDiscount::first();
            
            return view('ItemManagementModule.update_discount')->with(['user'=> $user, 'discount'=> $discount]);
        }
        return redirect('login');
    }

    //A function to update position discount
    public function updateDiscount(Request $request)
    {
        if(Auth::check())
        {
            $request->validate([
                'discountHQ' => 'required',
                'discountMasterLeader' => 'required',
                'discountLeader' => 'required',
                'discountMasterStockist' => 'required',
                'discountStockist' => 'required',
                'discountMasterAgent' => 'required',
                'discountAgent' => 'required', 
                'discountDropship' => 'required'
            ]);
    
            $data = $request->all();

            $product = Product::where('status_data',1)->get();

            $discount = PositionDiscount::first();

            if(isset($discount)){

                $saved = PositionDiscount::where('posDiscId',1) //forever only one row
                        ->update([
                            'discountHQ' => $data['discountHQ'],
                            'discountMasterLeader' => $data['discountMasterLeader'],
                            'discountLeader' => $data['discountLeader'],
                            'discountMasterStockist' => $data['discountMasterStockist'],
                            'discountStockist' => $data['discountStockist'],
                            'discountMasterAgent' => $data['discountMasterAgent'],
                            'discountAgent' => $data['discountAgent'], 
                            'discountDropship' => $data['discountDropship']
                        ]);

            }else{
                $add_discount = new PositionDiscount;
                $add_discount->discountHQ = $data['discountHQ'];
                $add_discount->discountMasterLeader = $data['discountMasterLeader'];
                $add_discount->discountLeader = $data['discountLeader'];
                $add_discount->discountMasterStockist = $data['discountMasterStockist'];
                $add_discount->discountStockist = $data['discountStockist'];
                $add_discount->discountMasterAgent = $data['discountMasterAgent'];
                $add_discount->discountAgent = $data['discountAgent']; 
                $add_discount->discountDropship = $data['discountDropship'];
                $saved = $add_discount->save();
            }

            foreach($product as $p){

                $saved = Product::where('productId',$p->productId)
                        ->update([
                            'priceHQ' => $p->productSellPrice - ($p->productSellPrice * ($data['discountHQ']/ 100)),
                            'priceMasterLeader' => $p->productSellPrice - ($p->productSellPrice * ($data['discountMasterLeader']/ 100)),
                            'priceLeader' => $p->productSellPrice - ($p->productSellPrice * ($data['discountLeader']/ 100)),
                            'priceMasterStockist' => $p->productSellPrice - ($p->productSellPrice * ($data['discountMasterStockist']/ 100)),
                            'priceStockist' => $p->productSellPrice - ($p->productSellPrice * ($data['discountStockist']/ 100)),
                            'priceMasterAgent' => $p->productSellPrice - ($p->productSellPrice * ($data['discountMasterAgent']/ 100)),
                            'priceAgent' => $p->productSellPrice - ($p->productSellPrice * ($data['discountAgent']/ 100)), 
                            'priceDropship' => $p->productSellPrice - ($p->productSellPrice * ($data['discountDropship']/ 100))
                        ]);
            }

            $user = User::where('id', Auth::id())->first();

            if($saved){
                return redirect()->route('view_discount')->with('success', 'Discount successfully updated!');
            }else{
                return redirect()->route('view_update_discount');
            }
        }
        return redirect('login');
    }

    //A function to display product discount page
    public function viewProductDiscount(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $discount = ProductDiscount::get();
            
            return view('ItemManagementModule.view_product_discount')->with(['user'=> $user,'discount'=> $discount]);
        }
        return redirect('login');
    }

    //A function to navigate user to the page to update product discount
    public function viewUpdateProductDiscount(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $discount = ProductDiscount::get();
            
            return view('ItemManagementModule.update_product_discount')->with(['user'=> $user, 'discount'=> $discount]);
        }
        return redirect('login');
    }

    //A function to update product discount
    public function updateProductDiscount(Request $request)
    {
        if(Auth::check())
        {
            $saved_delete = 0;
            $saved_add = 0;
            $saved_update = 0;

            $request->validate([
                'name' => 'required',
                'disc' => 'required',
            ]);

            if(isset($request->switch[0])){
                $switch = $request->switch[0];
            }else{
                $switch = -1;
            }

            foreach($request->name as $bil => $data)
            {
                $discount = ProductDiscount::where('prodDiscId', $request->id[$bil])->first();

                if(isset($discount)){
                    if($request->flag[$bil] == 2){
                        $saved_delete = ProductDiscount::where('prodDiscId',$request->id[$bil])->delete();
                    }
                    else{
                        if($switch == $bil){
                           $saved_update = ProductDiscount::where('prodDiscId',$request->id[$bil])
                                ->update([
                                    'productDiscount' => $request->disc[$bil],
                                    'discountName' => $request->name[$bil],
                                    'status' => 1
                                ]); 
                        }else{
                            $saved_update = ProductDiscount::where('prodDiscId',$request->id[$bil])
                                ->update([
                                    'productDiscount' => $request->disc[$bil],
                                    'discountName' => $request->name[$bil],
                                    'status' => 0
                                ]);
                        }
                         
                    }
                    
                }else{
                    if($switch == $bil){

                        $add_discount = new ProductDiscount;
                        $add_discount->productDiscount = $request->disc[$bil];
                        $add_discount->discountName = $request->name[$bil];
                        $add_discount->status = 1;
                        $saved_add = $add_discount->save();

                    }else{

                        $add_discount = new ProductDiscount;
                        $add_discount->productDiscount = $request->disc[$bil];
                        $add_discount->discountName = $request->name[$bil];
                        $add_discount->status = 0;
                        $saved_add = $add_discount->save();

                    } 
                }
            }

            $product = Product::where('status_data',1)->get();
            $active_discount = ProductDiscount::where('status',1)->first();

            foreach($product as $p){

                if($active_discount){
                    $saved = Product::where('productId',$p->productId)
                        ->update([
                            'productDiscountPrice' => $p->productSellPrice - ($p->productSellPrice * ($active_discount->productDiscount/ 100))
                        ]);  
                }else{
                    $saved = Product::where('productId',$p->productId)
                        ->update([
                            'productDiscountPrice' => 0
                        ]);
                }
                
            }

            $user = User::where('id', Auth::id())->first();

            return redirect()->route('view_product_discount')->with('success', 'Discount successfully updated!');
        }
        return redirect('login');
    }

}
