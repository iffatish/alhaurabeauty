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
                width: 60%;
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
                color: white;
                background-color: #FF2667;
                padding: 0.938rem 0.938rem;
            }
            .view a{
                color: #FF2667;
            }
            .view a:link{
                text-decoration:none;
                font-weight: bold;
            }
            .view a:hover{
                text-decoration: underline;
            }
            .view a:active {
                text-decoration: #FF2667;
            }
            .message{
                position:fixed;
                background-color:#C1E1C1;
                color:#023020;
                padding:15px;
                box-shadow: 0 0.125rem 0.063rem black;
            }
            .message a:hover{cursor:pointer;}
            .message a{
                color: black;
            }
            .order td{
                vertical-align: top;
            }
        </style>
    </head>
    <body>

        <div class="white-top">
            <div class="logo-menu">
                <img class="logo" src="images/logoalhaura.jpg" height="80" width="auto">
                <div class="menu">
                    <a href="{{route('dashboard')}}">HOME</a>
                    <a href="{{route('view_order_list')}}" style="color:#FF2667">ORDER</a>
                    <a href="">REPORT</a>
                    <a href="{{route('view_stock')}}">STOCK</a>
                    @if($user->userPosition != "HQ")
                    <a href="{{route('view_team_list')}}">TEAM</a>
                    @endif
                </div>
            </div>
            <div class="dropdown" style="float:right;">
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
            <a href="{{route('view_order_list')}}"><button style="color:#FF2667 ;background-color:white;border: 0.188rem solid #FF2667">View Order</button></a>
            <a href="{{route('add_order')}}"><button>Add Order</button></a>
            
        </div>

        <div class="content">
            <table width="100%">
                <tr>
                    <th width="10%" style="border-right: 0.063rem solid white">No.</th>
                    <th width="20%" style="border-right: 0.063rem solid white">Customer Name</th>
                    <th width="20%" style="border-right: 0.063rem solid white">Order Date</th>
                    <th width="20%" style="border-right: 0.063rem solid white">No. of items</th>
                    <th width="20%" style="border-right: 0.063rem solid white">Order Price (RM)</th>
                    <th width="20%">Details</th>
                </tr>
                @if($order->count() > 0)
                    @foreach($order as $i => $data)
                    <tr class="order">
                        <td class="center" style="border-right: 0.063rem solid #E8E8E8">{{($i + 1)}}</td>
                        <td style="border-right: 0.063rem solid #E8E8E8;padding-left:0.5rem;">{{$data->custName}}</td>
                        <td class="center" style="border-right: 0.063rem solid #E8E8E8">{{date('d-m-Y', strtotime($data->orderDate))}}</td>
                        <td class="center" style="border-right: 0.063rem solid #E8E8E8">{{$total_items[$i]}}</td>
                        <td class="center" style="border-right: 0.063rem solid #E8E8E8">{{$data->orderPrice}}</td>
                        <td class="view center"><a href="">view</a></td>
                    </tr>
                    @endforeach
                @else
                <tr class="center">
                    <td colspan="6" style="color:Dimgrey;">No results found</td>
                </tr>
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
