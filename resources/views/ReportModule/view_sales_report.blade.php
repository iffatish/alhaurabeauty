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
                margin-top: 1.875rem;
                margin-left: 3.125rem;
                color: black;
            }
            .content{
                width: 60%;
                margin: auto;
                margin-top: 30px;
                margin-bottom: 6.25rem;
            }
            .center{
                text-align: center;
            }
            .current-user{
                padding-right: 1.563rem;
                color: dimgrey;
            }
            h1{
                margin-top: 50px;
                color: #FF2667;
                padding: 0;
            }
            .content table{
                border-collapse: collapse;
            }
            .tb_report td{
                padding: 15px;
                background-color: white;
                vertical-align: top;
            }
            .tb_report th{
                color: white;
                background-color: #FF2667;
                padding: 15px;
            }
            .mid{
                text-align: center;
            }
            .list{
                padding-left: 15px;
                margin: 0;
            }
            .list li{
                padding-left: 20px;
            }

            li:not(:last-child) {
                margin-bottom: 10px;
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
                    <a href="{{route('view_sales_report')}}" style="color:#FF2667">REPORT</a>
                    <a href="{{route('view_stock')}}">STOCK</a>
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

        <div class="center">
            <h1>Sales Report</h1>
        </div>

        <div class="content">
            @if($user->userPosition != "HQ")
            <table width="100%" class="tb_report">
                <tr><th colspan="3">DAILY SALES REPORT</th></tr>
                <tr><td width="20%">Name</td><td width="5%" class="mid">:</td><td><b>{{$user->userName}}</b></td></tr>
                <tr><td>Report Type</td><td class="mid">:</td><td><b>Daily</b></td></tr>
                <tr><td>Date</td><td class="mid">:</td><td><b>{{$current_date}}</b></td></tr>
                <tr><td>Quantity Sold</td><td class="mid">:</td><td><b>{{$total_items}}</b></td></tr>
                <tr>
                    <td>Product(s) Sold</td>
                    <td class="mid">:</td>
                    <td>
                        <b>
                            <ol class="list">
                                @php
                                    $total_sales = 0;
                                @endphp

                                @foreach($product_list as $i => $product_list)

                                @php
                                    $total_sales += $total_product_price[$i];
                                @endphp

                                    <li>{{$product_list->productName}} ({{$total_product[$i]}}) - RM {{number_format($total_product_price[$i], 2, '.', '')}}</li>
                                @endforeach
                            </ol>
                        </b>
                    </td>
                </tr>
                <tr><td>Total Sales</td><td class="mid">:</td><td><b>RM {{number_format($total_sales, 2, '.', '')}}</b></td></tr>
                <tr><td>Capital</td><td class="mid">:</td><td><b>RM {{number_format($total_product_price[$i], 2, '.', '')}}</b></td></tr>
                <tr><td>Profit</td><td class="mid">:</td><td><b>RM {{number_format($total_product_price[$i], 2, '.', '')}}</b></td></tr>
            </table>
            @else
            <table width="100%" class="tb_report">
                <tr><th></th></tr>
            </table>
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
        </script>


    </body>
</html>
