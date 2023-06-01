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
                top: 230px;
                right:90px;
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
            <table width="100%" class="tb_report">
                <tr><th colspan="4">TEAM SALES REPORT</th></tr>
                    <tr><td>Team <br><hr></td><td>Restock (RM)<br><hr></td><td>Sales (RM)<br><hr></td><td>Profit (RM)<br><hr></td></tr>
                    @foreach($teams as $team)
                    <tr><td>{{$team->teamName}}</td><td>0</td><td>0</td><td>0</td></tr>
                    @endforeach
            </table>
        </div>

        <div class="report-menu">
            <table>
                <tr><td><a href="{{route('view_sales_report')}}">Daily</a></td></tr>
                <tr><td><a href="{{route('view_monthly_sales_report')}}">Monthly</a></td></tr>
                <tr><td><a href="{{route('view_yearly_sales_report')}}">Yearly</a></td></tr>
                @if($user->userPosition == "HQ")
                <tr><td style="background-color:#871437;"><a href="{{route('view_team_sales_report')}}">View Team Sales Report</a></td></tr>
                @endif
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
