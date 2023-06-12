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
                margin-top: 15px;
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
            .report-menu tr:first-of-type td:first-of-type{
                border-top-left-radius: 10px;
            }
            .report-menu tr:first-of-type td:last-of-type{
                border-top-right-radius: 10px;
            }
            .report-menu tr:last-of-type td:first-of-type {
                border-bottom-left-radius: 10px;
            }
            .report-menu tr:last-of-type td:last-of-type {
                border-bottom-right-radius: 10px;
            }
            .report-menu{
                position: absolute;
                top: 280px;
                right:110px;
                font-size: 0.875rem;
            }
            .report-menu td{
                padding: 0.938rem 0.938rem;
                text-align: center;
                background-color: #FF2667;
                box-shadow: 0 0.125rem 1px dimgrey;
                cursor: pointer;
                border-bottom: 0.063rem solid white;
            }
            .report-menu td:hover{
                background-color: #871437;
            }
            .report-menu a{
                color:white;
                text-decoration: none;
            }
            .report-menu a:link{
                text-decoration:none;
            }
            input[type=month]{
                font-family: 'Open Sans', sans-serif;
                width: 9.375rem;
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
                padding: 0.313rem 1.25rem;
                border-radius: 0.25rem;
                cursor: pointer;
            }
            .tm-btn button{
                color: white;
                background-color: #FF2667;
                border: none;
                padding: 0.625rem 1.875rem;
                border-radius: 1.875rem;
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
                    <a href="{{route('view_stock')}}">STOCK</a>
                    @if($user->userPosition != "HQ")
                    <a href="{{route('view_team_list')}}" style="color:#FF2667">TEAM</a>
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

        <div class="tm-btn" style="margin: 3.125rem 0 1.25rem 6.25rem;">
            <a href="{{route('view_team_member', ['teamId' => $teamId])}}"><button style="color: white;background-color:#FF2667;">Back to Team Member</button></a>
        </div>

        <div class="center">
            <h1>Sales Report</h1>
        </div>

        <div class="content">
            <table width="100%" class="tb_report">
                <tr><th colspan="3">MONTHLY SALES REPORT</th></tr>
                <tr>
                    <td colspan="3" style="text-align:right;">
                        <form method="get" action="{{route('update_monthly_teammate_sales_report')}}">
                            @csrf
                            <input type="hidden" name="teamId" value="{{$teamId}}">
                            <input type="hidden" name="teamMemberId" value="{{$teamMemberId}}">
                            <input name="year_month" id="year_month" type="month">
                            <input type="submit" value="Search">
                        </form>
                    </td>
                </tr>
                @if($report->totalSalesQty != 0)
                <tr><td width="20%">Name</td><td width="5%" class="mid">:</td><td><b>{{$teammate->userName}}</b></td></tr>
                <tr><td>Report Type</td><td class="mid">:</td><td><b>Monthly</b></td></tr>
                <tr><td>Month</td><td class="mid">:</td><td><b>{{$month}}</b></td></tr>
                <tr><td>Number of Orders</td><td class="mid">:</td><td><b>{{$report->totalSalesQty}}</b></td></tr>
                <tr><td>Quantity Sold</td><td class="mid">:</td><td><b>{{$report->quantitySold}}</b></td></tr>
                <tr>
                    <td>Product(s) Sold</td>
                    <td class="mid">:</td>
                    <td>
                        <b>
                            <ol class="list">
                                @php
                                    $products = array();
                                    $products = explode(',', $report->productSold);
                                @endphp

                                @foreach($products as $p)
                                    <li>{{$p}}</li>
                                @endforeach
                            </ol>
                        </b>
                    </td>
                </tr>
                <tr><td>Total Sales</td><td class="mid">:</td><td><b>RM {{number_format($report->totalSales, 2, '.', '')}}</b></td></tr>
                <tr><td>Capital</td><td class="mid">:</td><td><b>RM {{number_format($report->capital, 2, '.', '')}}</b></td></tr>
                <tr><td>Profit</td><td class="mid">:</td><td><b>RM {{number_format($report->profit, 2, '.', '')}}</b></td></tr>
                @else
                <tr><td width="20%">Name</td><td width="5%" class="mid">:</td><td><b>{{$teammate->userName}}</b></td></tr>
                <tr><td>Report Type</td><td class="mid">:</td><td><b>Monthly</b></td></tr>
                <tr><td>Month</td><td class="mid">:</td><td><b>{{$month}}</b></td></tr>
                <tr><td>Number of Orders</td><td class="mid">:</td><td><b>0</b></td></tr>
                <tr><td>Quantity Sold</td><td class="mid">:</td><td><b></b></td></tr>
                <tr>
                    <td>Product(s) Sold</td>
                    <td class="mid">:</td>
                    <td></td>
                </tr>
                <tr><td>Total Sales</td><td class="mid">:</td><td><b></b></td></tr>
                <tr><td>Capital</td><td class="mid">:</td><td><b></b></td></tr>
                <tr><td>Profit</td><td class="mid">:</td><td><b></b></td></tr>
                @endif
            </table>
        </div>

        <div class="report-menu">
            <table>
                <tr><td><a href="{{route('view_teammate_sales_report', [ 'teamId' => $teamId, 'teamMemberId' => $teamMemberId])}}">Daily</a></td></tr>
                <tr><td style="background-color:#871437;"><a href="{{route('view_monthly_teammate_sales_report', [ 'teamId' => $teamId, 'teamMemberId' => $teamMemberId])}}">Monthly</a></td></tr>
                <tr><td><a href="{{route('view_yearly_teammate_sales_report', [ 'teamId' => $teamId, 'teamMemberId' => $teamMemberId])}}">Yearly</a></td></tr>
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
        </script>


    </body>
</html>
