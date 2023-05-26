<!DOCTYPE html>
<html>
    <head>
        <title>ABSMS</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'></link> 
        <style>
            body {
                font-family: 'Open Sans', sans-serif;
                background-color: #FFE5F0;
            }
            .white-top{
                background-color: white;
                padding: 0.625rem 0.938rem;
                text-align: left;
                box-shadow: 0 0.188rem 0.188rem grey;
                display:flex;
                justify-content: space-between;
            }
            .center{
                text-align: center;
            }

            .user{
                margin-top:1.563rem;
                margin-right:2.5rem;
            }

            .dropdown {
                position: relative;
                display: inline-block;
            }

            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f9f9f9;
                min-width: 10rem;
                box-shadow: 0 0.5rem 1rem 0 rgba(0,0,0,0.2);
                z-index: 1;
                overflow: hidden;
            }

            .dropdown-content a {
                color: black;
                padding: 0.75rem 1rem;
                text-decoration: none;
                display: block;
            }

            .dropdown-content a:hover {background-color: #f1f1f1; color: #FF2667}

            .dropdown:hover .dropdown-content {
                display: block;
            }
            a{
                color: black;
            }
            .menu a:link{
                text-decoration:none;
                font-weight: bold;
            }
            .menu a:hover{
                color: #FF2667;
            }
            .menu a:active {
                text-decoration: #FF2667;
            }
            .logo-menu{
                display: flex;
            }
            .menu{
                display: flex;
                justify-content: space-between;
            }
            .menu a{
                margin-top:1.875rem;
                margin-left:3.125rem;
            }
            .stock-btn button{
                color: white;
                background-color: #FF2667;
                border: none;
                padding: 0.625rem 1.875rem;
                border-radius: 1.875rem;
                box-shadow: 0 0.125rem 0.063rem black;
                cursor: pointer;
                margin-left: 0.938rem;
            }
            .content{
                width: 80%;
                margin: auto;
                margin-top: 1.875rem;
                margin-bottom: 6.25rem;
                display: flex;
                flex-wrap: wrap;
                justify-content: space-evenly;
            }
            table{
                border-collapse: collapse;
            }
            td{
                padding: 15px;
                background-color: white;
            }
            .product{
                margin: 0 auto 0.5rem 0;
                width: 48%;
                display: flex;
                border: 0.063rem solid #dfdfdf;
                background-color:white;
                padding: 0.5rem;
                border-radius: 0.625rem;
            }
            .image{
                border: 0.063rem solid #dfdfdf;
            }
            .desc{
                text-align: right;
            }
            .edit-dlt-btn{
                color: white;
                background-color: #FF2667;
                border: none;
                padding: 0.625rem 1.875rem;
                border-radius: 1.875rem;
                box-shadow: 0 0.125rem 0.063rem black;
                cursor: pointer;
                margin-left: 0.938rem;
            }
            .message{
                position:fixed;
                background-color:#C1E1C1;
                color:#023020;
                padding:15px;
                box-shadow: 0 0.125rem 0.063rem black;
            }
            .message a:hover{cursor:pointer;}
            .current-user{
                padding-right: 1.563rem;
                color: dimgrey;
            }
        </style>
    </head>
    <body>

        <div class="white-top">
            <div class="logo-menu">
                <img class="logo" src="images/logoalhaura.jpg" height="80" width="auto">
                <div class="menu">
                    <a href="{{route('dashboard')}}">HOME</a>
                    <a href="{{route('view_order_list')}}">ORDER</a>
                    <a href="{{route('view_sales_report')}}">REPORT</a>
                    <a href="{{route('view_stock')}}" style="color:#FF2667">STOCK</a>
                    @if($user->userPosition != "HQ")
                    <a href="{{route('view_team_list')}}">TEAM</a>
                    @endif
                </div>
            </div>
            <div class="dropdown" style="float:right;">
                <span class="current-user">{{$user->userName}} ({{$user->userPosition}})</span>
                <img class="user" src="images/user.png" height="35" width="auto">

                <div id="myDropdown" class="dropdown-content" style="right:0;">
                    <a href="{{route('user.account')}}">User Account</a>
                    <a href="" id="logout-button" data-link="{{route('logout')}}">Logout</a>
                </div>
            </div>         
        </div>

        @if ($message = Session::get('success'))
        <div class="message" id="message">
            <span>{{ $message }}</span>
            <a href="javascript:close()"><i class="fa fa-times"></i></a>
        </div>
        @endif

        <div class="stock-btn" style="margin: 3.125rem 6.25rem">
            <a href="{{route('view_stock')}}"><button style="color:#FF2667 ;background-color:white;border: 0.188rem solid #FF2667">View Products</button></a>
            @if($user->userPosition == "HQ")
                <a href="{{route('add_product')}}"><button>Add New Product</button></a>
                <a href="{{route('view_discount')}}"><button>Discount</button></a>
            @endif
            <a href="{{route('restock_product')}}"><button>Restock</button></a>
            <a href="{{route('view_restock_list')}}"><button>View Restock</button></a>
        </div>

        @if($product_discount)
            <div style="background-color: #40bf40;color:white;padding:5px;text-align:center;">
                <marquee scrollamount="10"><b style="text-shadow: 1px 1px 0px black;">>> Discount {{$product_discount->discountName}} {{$product_discount->productDiscount}}% <<</b></marquee>
            </div>
        @endif

        <div class="content">
            @if($product->count()>0)
                @foreach($product as $i => $product)
                    <div class="product">
                        <img class="image" src="images/products/{{$product->productImage}}" width="200px" height="200px">
                        <table width="100%">
                            <tr>
                                <td colspan="2" style="font-size: 1.125rem;color: #FF2667;"><b>{{$product->productName}}</b></td>
                            </tr>
                            <tr>
                                @if($product->productDiscountPrice > 0)
                                    <td>Price</td><td class="desc"><b>RM </b><s>{{$product->productSellPrice}}</s>&nbsp;&nbsp;&nbsp;<b>{{$product->productDiscountPrice}}</b></td>
                                @else
                                    <td>Price</td><td class="desc"><b>RM {{$product->productSellPrice}}</b></td>
                                @endif
                            </tr>
                            <tr>
                                @php
                                    $product_qty_col = $product->productId . "_qty";
                                @endphp
                                <td>Quantity</td><td class="desc"><b>{{$user_stock->$product_qty_col}}</b></td>
                            </tr>
                            @if($user->userPosition == "HQ")
                            <tr>
                                <td><a href="{{route('update_product',['productId'=> $product->productId])}}"><button class="edit-dlt-btn" style="background-color:#FF2667;">Edit</button></a></td>
                                <td><a href=""><button class="edit-dlt-btn" style="background-color:grey;">Delete</button></a></td>
                            </tr>
                            @endif
                        </table> 
                    </div>
                @endforeach
            @else
            <div style="text-align:center;background-color:white;padding:10px; width:100%">
                <span style="color:Dimgrey;">No products found</span>
            </div>    
            @endif 
        </div>

        <script>
            $("#logout-button").click(function(e){

                e.preventDefault();
                var link = $(this).data("link");             
                Swal.fire({
                    html: "<b>Are you sure you want to <span style='color:#FF2667'>logout</span>?</b>",
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    confirmButtonColor: '#FF2667',
                    }).then((result) => {
                    if (result.isConfirmed) {
                            window.location.href = link;
                        }
                    });
            });
            
            function close() {
                var x = document.getElementById("message");
                x.style.display = "none";
            }
        </script>


    </body>
</html>
