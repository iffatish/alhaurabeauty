<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductQuantity;
use App\Models\RestockInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function viewStock()
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $product = Product::get();
            $user_stock = ProductQuantity::where('employeeId', Auth::id())->first();
            
            return view('ItemManagementModule.view_stock')->with(['user'=> $user, 'product'=> $product, 'user_stock' => $user_stock]);
        }
        return redirect('login');
    }

    public function viewAddProduct()
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            
            return view('ItemManagementModule.add_new_product')->with('user', $user);
        }
        return redirect('login');
    }

    public function addProduct(Request $request)
    {
        if(Auth::check())
        {
            $request->validate([
                'productName' => 'required',
                'productImage' => 'required',
                'productSellPrice' => 'required',
                'priceHQ' => 'required',
                'priceMasterLeader' => 'required',
                'priceLeader' => 'required',
                'priceMasterStockist' => 'required',
                'priceStockist' => 'required',
                'priceMasterAgent' => 'required',
                'priceAgent' => 'required',
                'priceDropship' => 'required'
            ]);
    
            $data = $request->all();
            $imageName = time().'.'.$request->productImage->extension();
            $request->productImage->move(public_path('images/products'), $imageName);

            Product::create([
                'productName' => $data['productName'],
                'productImage' => $imageName,
                'productSellPrice' => $data['productSellPrice'],
                'priceHQ' => $data['priceHQ'],
                'priceMasterLeader' => $data['priceMasterLeader'],
                'priceLeader' => $data['priceLeader'],
                'priceMasterStockist' => $data['priceMasterStockist'],
                'priceStockist' => $data['priceStockist'],
                'priceMasterAgent' => $data['priceMasterAgent'],
                'priceAgent' => $data['priceAgent'],
                'priceDropship' => $data['priceDropship']
            ]);

            //Add column in product_quantity table
            $new_product = Product::where('productName', $data['productName'])->first();
            $statement = "ALTER TABLE product_quantity ADD ".$new_product->productId."_qty INT DEFAULT 0";
            DB::statement($statement);

            //Add column in restock_information table
            $statementt = "ALTER TABLE restock_information ADD ".$new_product->productId."_restock_qty INT DEFAULT 0";
            DB::statement($statementt);

            //Add column in order table
            $statementtt = "ALTER TABLE order_information ADD ".$new_product->productId."_order_qty INT DEFAULT 0";
            DB::statement($statementtt);

            $user = User::where('id', Auth::id())->first();
            $product = Product::get();
            $user_stock = ProductQuantity::where('employeeId', Auth::id())->first();

            return redirect('view_stock')->with(['user'=> $user, 'product'=> $product, 'user_stock' => $user_stock, 'success' => 'New product successfully added!']);
        }
        return redirect('login');
    }

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
    
    function updateProduct(Request $request)
    {
        if(Auth::check())
        {
            $request->validate([
                'productName' => 'required',
                'productSellPrice' => 'required',
                'priceHQ' => 'required',
                'priceMasterLeader' => 'required',
                'priceLeader' => 'required',
                'priceMasterStockist' => 'required',
                'priceStockist' => 'required',
                'priceMasterAgent' => 'required',
                'priceAgent' => 'required',
                'priceDropship' => 'required'
            ]);
    
            $data = $request->all();

            $item = Product::where('productId', $request->productId)->first();
            
            if($request->productImage){

                $imageName = time().'.'.$request->productImage->extension();
                $request->productImage->move(public_path('images/products'), $imageName);

                $saved = Product::where('productId', $request->productId)
                        ->update([
                            'productName' => $request->productName,
                            'productImage' => $imageName,
                            'productSellPrice' => $request->productSellPrice,
                            'priceHQ' => $request->priceHQ,
                            'priceMasterLeader' => $request->priceMasterLeader,
                            'priceLeader' => $request->priceLeader,
                            'priceMasterStockist' => $request->priceMasterStockist,
                            'priceStockist' => $request->priceStockist,
                            'priceMasterAgent' => $request->priceMasterAgent,
                            'priceAgent' => $request->priceAgent,
                            'priceDropship' => $request->priceDropship
                        ]);

            }else{
                $saved =Product::where('productId', $request->productId)
                        ->update([
                            'productName' => $request->productName,
                            'productSellPrice' => $request->productSellPrice,
                            'priceHQ' => $request->priceHQ,
                            'priceMasterLeader' => $request->priceMasterLeader,
                            'priceLeader' => $request->priceLeader,
                            'priceMasterStockist' => $request->priceMasterStockist,
                            'priceStockist' => $request->priceStockist,
                            'priceMasterAgent' => $request->priceMasterAgent,
                            'priceAgent' => $request->priceAgent,
                            'priceDropship' => $request->priceDropship
                        ]);
            }

            $user = User::where('id', Auth::id())->first();
            $product = Product::get();

            if($saved){
                return redirect()->route('view_stock')->with('success', 'Product successfully updated!');
            }else{
                return redirect()->route('update_product', ['productId' => $item->productId])->with(['user'=> $user, 'product' => $product]);
            }
        }
        return redirect('login');
    }

    public function viewRestockProduct()
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $product = Product::get();
            
            return view('ItemManagementModule.restock_product')->with(['user'=> $user, 'product'=> $product]);
        }
        return redirect('login');
    }

    public function addItemRestockInfo(Request $request)
    {
        if(Auth::check())
        {
            $request->validate([
                'batchNo' => 'required',
                'restockFrom' => 'required',
                'restockPaymentMethod' => 'required',
                'restockDate' => 'required',
            ]);

            $data = $request->all();
    
            $all_product = Product::get();
            $position = User::where('id', Auth::id())->value('userPosition');
            $product_quantity = ProductQuantity::where('employeeId', Auth::id())->first();

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
            
            //add row in Restock Information
            $restock = new RestockInformation;
            $restock->batchNo = $request->batchNo;
            $restock->restockFrom = $request->restockFrom;
            $restock->restockPaymentMethod = $request->restockPaymentMethod;
            $restock->restockDate = $request->restockDate;
            foreach($all_product as $dataaa)
            {
                $name = $dataaa->productId . "_restock_qty";
                $restock->$name = $data[$name];
                $total_price += $dataaa->$search * $data[$name];
            }
            $restock->restockPrice = $total_price;
            $restock->employeeId = Auth::id();
            $restock->save();

            //update table Product Quantity for current user
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


            $user = User::where('id', Auth::id())->first();
            $product = Product::get();
            $user_stock = ProductQuantity::where('employeeId', Auth::id())->first();
            return redirect('view_stock')->with(['user'=> $user, 'product'=> $product, 'user_stock' => $user_stock, 'success' => 'Product successfully restocked!']);
        }
        return redirect('login');
    }

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
            
            $split_position = preg_split("/[\s,]+/", $user->userPosition);
            $capitalize_word = array();
            foreach($split_position as $dataa)
            {
                array_push($capitalize_word,ucfirst($dataa));
            }

            $searchPrice = "price";

            foreach($capitalize_word as $d)
            {
                $searchPrice .= $d; 
            }

            return view('ItemManagementModule.view_restock_details')->with([
                'user'=> $user, 
                'restock'=> $restock, 
                'total_items' => $total_items,
                'product_restock' => $product_restock,
                'searchPrice' => $searchPrice
            ]);
        }
        return redirect('login');
    }

}
