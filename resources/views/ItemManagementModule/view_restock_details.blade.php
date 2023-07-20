<!-- View restock details page. A page that will display details of the selected restock information from the view restock list page. -->
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
            .menu a{
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
            .restock-btn button{
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
                width: 70%;
                margin: auto;
                margin-top: 3.75rem;
                margin-bottom: 6.25rem;
                background-color:white;
                display: flex;
                padding: 1.875rem;
                border-radius: 1.875rem;
                flex-direction: row;
            }
            .content table{
                border-collapse: collapse;
            }
            .first th{
                color: #FF2667;
                font-size: 1.5rem;
                padding-bottom: 0.938rem;
            }
            .first td{
                padding-bottom: 0.938rem;
                padding-right: 2.5rem;
                border-right: 1px solid #C8C8C8;
                vertical-align: top;
            }
            .second td{
                padding: 0.625rem 0.938rem;
                background-color: white;
                border: 0.063rem solid #C8C8C8;
                vertical-align: top;
            }
            .second th{
                color: white;
                background-color: #FF2667;
                padding: 0.938rem 0.938rem;
                font-size: 0.875rem;
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

        <div class="restock-btn" style="margin: 3.125rem 0 1.25rem 6.25rem;">
            <a href="{{route('view_restock_list')}}"><button style="color: white;background-color:#FF2667;">Back to Restock List</button></a>
        </div>

        <div class="content">
            <div width="30%" style="margin-right: 1.875rem;">
                <table class="first">
                    <tr>
                        <th style="text-align:left;">Restock Details</th>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Month : <b>{{date('F', strtotime($restock->restockDate))}}</b></td>
                    </tr>
                    <tr>
                        <td>Batch Number : <b>{{$restock->batchNo}}</b></td>
                    </tr>
                    <tr>
                        <td>Restock Date : <b>{{date('d-m-Y', strtotime($restock->restockDate))}}</b></td>
                    </tr>
                    <tr>
                        <td>Position : <b>{{$user->userPosition}}</b></td>
                    </tr>
                    <tr>
                        <td>Payment Method : <b>{{$restock->restockPaymentMethod}}</b></td>
                    </tr>
                    <tr>
                        <td>Number of Restocked Items : <b>{{$total_items}}</b></td>
                    </tr>
                    <tr>
                        <td>Restock from : <b>{{$restock->restockFrom}}</b></td>
                    </tr>
                </table>
            </div>
            <div style="padding-top:2.5rem">
                <table class="second" width="100%">
                    <tr>
                        <th style="border-right: 0.063rem solid white">No.</th>
                        <th style="border-right: 0.063rem solid white">Item</th>
                        <th style="border-right: 0.063rem solid white">Price Per Unit (RM)</th>
                        <th style="border-right: 0.063rem solid white">Quantity</th>
                        <th style="border-right: 0.063rem solid white">Cost (RM)</th>
                    </tr>
                    @foreach($product_restock as $i => $data)
                        <tr>
                            <td style="text-align:center;border-right: 0.063rem solid #E8E8E8">{{($i + 1)}}</td>
                            <td style="border-right: 0.063rem solid #E8E8E8">{{$data->productName}}</td>
                            @php $col_price = $data->productId . "_restock_price"; @endphp
                            <td style="text-align:right;border-right: 0.063rem solid #E8E8E8">{{number_format($restock->$col_price, 2, '.', '')}}</td>
                            @php $col = $data->productId . "_restock_qty"; @endphp
                            <td style="text-align:center;border-right: 0.063rem solid #E8E8E8">{{$restock->$col}}</td>
                            @php $cost = $restock->$col * $restock->$col_price @endphp
                            <td style="text-align:right;">{{number_format($cost, 2, '.', '')}}</td>
                        </tr>
                    @endforeach
                        <tr>
                            <td style="text-align:right;" colspan="4">Total Restock Price (RM) <br><i style="color:Dimgrey;font-size: 10px;">Overall price of restocked product(s) based on position</i></td>
                            <td style="text-align:right;">{{$restock->restockPrice}}</td>
                        </tr>
                </table>
            </div>  
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
