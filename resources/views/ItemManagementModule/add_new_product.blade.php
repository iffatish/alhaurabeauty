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
                margin-top: 3.75rem;
                margin-bottom: 6.25rem;
            }
            .center{
                text-align: center;
            }
            table{
                border-collapse: collapse;
            }
            td{
                padding-top: 0.625rem;
                padding-bottom: 0.625rem;
                background-color: white;
            }
            th{
                padding: 0.938rem 0;
                font-size: 1.5rem;
                color: #FF2667;
                background-color: white;
                text-align: left;
                padding-left: 3.125rem;
            }
            th:first-of-type {
                border-top-left-radius: 1.875rem;
            }
            th:last-of-type{
                border-top-right-radius: 1.875rem;
            }
            tr:last-of-type td:first-of-type {
                border-bottom-left-radius: 1.875rem;
            }
            tr:last-of-type td:last-of-type {
                border-bottom-right-radius: 1.875rem;
            }
            .input-title{
                padding-left: 3.125rem;
                font-weight: bold;
            }
            input[type=text], input[type=number] {
                width: 18.75rem;
                height: 1.875rem;
                padding: 0.313rem 0.313rem;
                display: inline-block;
                border: 0.063rem solid #ccc;
                border-radius: 0.25rem;
                box-sizing: border-box;
            }
            input[type=submit]{
                font-family: 'Open Sans', sans-serif;
                color: white;
                background-color: #FF2667;
                border: none;
                padding: 0.938rem 0;
                box-shadow: 0 0.125rem 0.063rem black;
                cursor: pointer;
                width: 18.75rem;
                border-radius: 0.25rem;
                margin-top:0.313rem;
            }
            input[type=file]{
                font-family: 'Open Sans', sans-serif;
                width: 18.75rem;
                height: 1.875rem;
                padding: 0.313rem 0.313rem;
                display: inline-block;
                border: 0.063rem solid #ccc;
                border-radius: 0.25rem;
                box-sizing: border-box;
            }
            .back{
                font-size:0.75rem;
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
            .current-user{
                padding-right: 1.563rem;
                color: dimgrey;
            }
            .update-btn button{
                color: white;
                background-color: #FF2667;
                border: none;
                padding: 0.625rem 1.875rem;
                border-radius: 0.25rem;
                box-shadow: 0 0.125rem 0.063rem black;
                cursor: pointer;
                margin-left: 0.938rem;
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

        <div class="stock-btn" style="margin: 3.125rem 6.25rem">
            <a href="{{route('view_stock')}}"><button>View Products</button></a>
            @if($user->userPosition == "HQ")
                <a href="{{route('add_product')}}"><button style="color:#FF2667 ;background-color:white;border: 0.188rem solid #FF2667">Add New Product</button></a>
                <a href="{{route('view_discount')}}"><button>Discount</button></a>
            @endif
            <a href="{{route('restock_product')}}"><button>Restock</button></a>
            <a href="{{route('view_restock_list')}}"><button>View Restock</button></a>
        </div>

        <div class="content">
            <table width="100%">
                <form method="post" action="{{route('product.add')}}" enctype="multipart/form-data">
                @csrf
                    <tr>
                        <th>Add Product</th><th></th>
                    </tr>
                    <tr>
                        <td width="30%" class="input-title">Product Name</td><td width="40%" class="center"><input required name="productName" type="text"></td>
                    </tr>
                    <tr>
                        <td class="input-title">Product Image</td><td class="center"><input required name="productImage" type="file" accept="image/png, image/gif, image/jpeg"></td>
                    </tr>
                    <tr>
                        <td class="input-title">Product Sell Price</td><td class="center"><input required name="productSellPrice" type="number" step=".01"></td>
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
                        <td></td><td class="center back" style="padding-bottom:1.875rem;"><input type="submit" value="+  Add Product"><br><br><a href="{{route('view_stock')}}">Cancel</a></td> 
                    </tr>    
                </form>
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
        </script>


    </body>
</html>
