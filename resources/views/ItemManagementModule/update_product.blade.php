<!DOCTYPE html>
<html>
    <head>
        <title>ABSMS</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
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
                width: 50%;
                margin: auto;
                margin-top: 60px;
                margin-bottom: 100px;
            }
            .center{
                text-align: center;
            }
            table{
                border-collapse: collapse;
            }
            td{
                padding-top: 10px;
                padding-bottom: 10px;
                background-color: white;
            }
            th{
                padding: 15px 0px;
                font-size: 24px;
                color: #FF2667;
                background-color: white;
                text-align: left;
                padding-left: 50px;
            }
            th:first-of-type {
                border-top-left-radius: 30px;
            }
            th:last-of-type{
                border-top-right-radius: 30px;
            }
            tr:last-of-type td:first-of-type {
                border-bottom-left-radius: 30px;
            }
            tr:last-of-type td:last-of-type {
                border-bottom-right-radius: 30px;
            }
            .input-title{
                padding-left: 50px;
                font-weight: bold;
            }
            input[type=text], input[type=number] {
                width: 300px;
                height: 30px;
                padding: 5px 5px;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }
            input[type=submit]{
                font-family: 'Open Sans', sans-serif;
                color: white;
                background-color: #FF2667;
                border: none;
                padding: 15px 0;
                font-weight: bold;
                box-shadow: 0px 2px 1px black;
                cursor: pointer;
                width: 300px;
                border-radius: 4px;
                margin-top:5px;
            }
            input[type=file]{
                font-family: 'Open Sans', sans-serif;
                width: 300px;
                height: 30px;
                padding: 5px 5px;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }
            .back{
                font-size:12px;
            }
            .back a{
                text-decoration: none;
            }
            .back a:link{
                text-decoration:none;
            }
            .back a:hover{
                color: #FF2667;
            }
            .back a:active {
                text-decoration: #FF2667;
            }
            .save{
                font-family: 'Open Sans', sans-serif;
                color: white;
                background-color: #FF2667;
                border: none;
                padding: 10px 30px;
                box-shadow: 0px 2px 1px black;
                cursor: pointer;
                width: 300px;
                border-radius: 4px;
            }
            .image{
                border: 1px solid #dfdfdf;
            }
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

        <div class="stock-btn" style="margin: 50px 100px">
            <a href="{{route('view_stock')}}"><button style="color:#FF2667 ;background-color:white;border: 3px solid #FF2667">View Products</button></a>
            @if($user->userPosition == "HQ")
                <a href="{{route('add_product')}}"><button>Add New Product</button></a>
                <a href="{{route('view_discount')}}"><button>Discount</button></a>
            @endif
            <a href="{{route('restock_product')}}"><button>Restock</button></a>
            <a href="{{route('view_restock_list')}}"><button>View Restock</button></a>
        </div>

        <div class="content">
            <table width="100%">
                <form method="post" action="{{route('product.update', ['productId'=> $product->productId])}}" enctype="multipart/form-data" id="form_update">
                @csrf
                    <tr>
                        <th>Edit Product</th><th></th>
                    </tr>
                    <tr>
                        <td><img class="image" src="images/products/{{$product->productImage}}" width="80%" height="auto" style="margin-left: 50px;"></td><td></td>
                    </tr>
                    <tr>
                        <td width="30%" class="input-title">Product Name</td><td width="40%" class="center"><input required name="productName" type="text" value="{{$product->productName}}" onchange="validateProduct()"></td>
                    </tr>
                    <tr>
                        <td class="input-title">Product Image</td><td class="center"><input name="productImage" type="file" accept="image/png, image/gif, image/jpeg"></td>
                    </tr>
                    <tr>
                        <td class="input-title">Product Sell Price</td><td class="center"><input required name="productSellPrice" type="number" step=".01" value="{{$product->productSellPrice}}"></td>
                    </tr>                   
                    <tr>
                        <td colspan="2">@if ($errors->any())
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li style="color:red;">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                    </tr>
                    <tr>
                    <td class="input-title"></td><td style="padding-bottom:40px;"class="center back"><button class="save" type="submit" form="form_update" value="Save"><i class='fa fa-save'></i>&nbsp;&nbsp;Save</button><br><br><a href="{{route('view_stock')}}">Cancel</a></td>
                    </tr>
                </form>
            </table>
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
                    allowOutsideClick: false,
                    backdrop: 'rgba(0,0,0,0.4)'
                    }).then((result) => {
                    if (result.isConfirmed) {
                            window.location.href = link;
                        }
                    });
            });
            
            function validateProduct(){

                var productName = $("input[name='productName']").val();
                $.ajax({
                    url: "{{route('validate_product')}}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "productName": productName
                    },
                    success: function(response){
                        if(response.success == false){
                            Swal.fire({
                                icon: 'error',
                                text: 'Product already exist!',
                                confirmButtonColor: '#FF2667',
                                allowOutsideClick: false,
                                backdrop: 'rgba(0,0,0,0.4)'
                            })
                            $("input[name='productName']").val("");
                        }
                    }
                });
            }
        </script>


    </body>
</html>
