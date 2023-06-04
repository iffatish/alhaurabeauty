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
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                vertical-align: top;
            }
            th{
                padding: 1.563rem 0 0.938rem 0;
                font-size: 1.5rem;
                color: #FF2667;
                background-color: white;
                text-align: left;
                padding-left: 3.125rem;
                vertical-align:bottom;
                border-bottom: 0.063rem solid #E8E8E8;
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
            input[type=text], input[type=number]{
                font-family: 'Open Sans', sans-serif;
                width: 18rem;
                height: 1.875rem;
                padding: 0.313rem 0.313rem;
                display: inline-block;
                border: 0.063rem solid #ccc;
                border-radius: 0.25rem;
                box-sizing: border-box;
            }
            select{
                font-family: 'Open Sans', sans-serif;
                width: 18rem;
                height: 1.875rem;
                padding: 0.313rem 0.313rem;
                display: inline-block;
                border: 0.063rem solid #ccc;
                border-radius: 0.25rem;
                box-sizing: border-box;
            }
            input[type=date]{
                font-family: 'Open Sans', sans-serif;
                width: 8rem;
                height: 1.875rem;
                padding: 0.313rem 0.313rem;
                display: inline-block;
                border: 0.063rem solid #ccc;
                border-radius: 0.25rem;
                box-sizing: border-box;
            }
            input[type=radio]{
                font-family: 'Open Sans', sans-serif;
                display: inline-block;
                border: 0.063rem solid #ccc;
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
                width: 18rem;
                border-radius: 0.25rem;
                margin-top:0.313rem;
            }
            #batchNo{
                font-family: 'Open Sans', sans-serif;
                width: 3.438rem;
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
            label{
                font-weight: normal;
            }
            .right{
                text-align:right;
            }
            .current-user{
                padding-right: 1.563rem;
                color: dimgrey;
            }
            select{
                font-family: 'Open Sans', sans-serif;
                padding: 0.313rem 0.313rem;
                display: inline-block;
                border: 0.063rem solid #ccc;
                border-radius: 0.25rem;
                box-sizing: border-box;
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
                <a href="{{route('add_product')}}"><button>Add New Product</button></a>
                <a href="{{route('view_discount')}}"><button>Discount</button></a>
            @endif
            <a href="{{route('restock_product')}}"><button style="color:#FF2667 ;background-color:white;border: 0.188rem solid #FF2667">Restock</button></a>
            <a href="{{route('view_restock_list')}}"><button>View Restock</button></a>
        </div>

        <div class="content">
            <table width="100%">
                <form method="post" action="{{route('add_item_restock_info')}}" enctype="multipart/form-data">
                @csrf
                    <tr>
                        <th>Restock Item</th><th style="color:black;font-size:0.875rem; text-align:right;padding-right:5.063rem;">Batch No.&nbsp;&nbsp;&nbsp;&nbsp;<input required type="number" name="batchNo" id="batchNo"></th>
                    </tr>
                    <tr>
                        <td colspan="2" class="input-title" style="padding-top:2rem;padding-bottom:2rem;">Restock Date:&nbsp;&nbsp;&nbsp;&nbsp;<input required name="restockDate" type="date"></td>
                    </tr>
                    <tr>
                        <td class="input-title" style="color: #FF2667;">Item</td><td class="right" style="color: #FF2667;padding-right:6.25rem;"><b>Quantity</b></td>
                    </tr>
                    @if($product->count() < 1)
                    <tr>
                        <td colspan="2" class="center" style="color:Dimgrey;">No products found</td>
                    </tr>
                    @endif
                    @foreach($product as $i => $product)
                    <tr>
                        @php
                            $product_qty_col = $product->productId . "_restock_qty";
                        @endphp
                        <td style="padding-left: 3.125rem;">{{$i +1}}) {{$product->productName}}</td><td class="right" style="padding-right:5.063rem;"><input style="width:6.25rem;" required type="number" min="0" name="{{$product_qty_col}}" value="0"></td>
                    </tr>
                    @endforeach

                    @if($user->userPosition == "HQ")
                    <tr>
                        <td colspan="2" class="input-title" style="padding-top:2rem;">Restock from&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input style="width:28.75rem" type="text" name="restockFrom"></td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="2" class="input-title" style="padding-top:2rem;">Restock from&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <select class="form-control" name="restockFrom" id="select-employee" style="width:300px;">
                                
                        </select></td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="2" class="input-title" style="padding-top:1rem;">Payment Method&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="restockPaymentMethod" value="Cash" id="cash"><label for="cash">Cash</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="restockPaymentMethod" value="Online Payment" id="online"><label for="online">Online Payment</label>
                        </td>
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
                    @if($product->count() < 1)
                    <tr>
                        <td colspan="2" class="center back" style="padding-bottom:1.875rem;"><input style="background-color:#cccccc;cursor:not-allowed;" type="submit" value="+  Restock" disabled><br><br><a href="{{route('view_stock')}}">Cancel</a></td> 
                    </tr>
                    @else
                    <tr>
                        <td colspan="2" class="center back" style="padding-bottom:1.875rem;"><input type="submit" value="+  Restock"><br><br><a href="{{route('view_stock')}}">Cancel</a></td> 
                    </tr>
                    @endif
                    
                </form>
            </table>
        </div>

        <script>
            $(document).ready(function() {

                $("#select-employee").select2({
                    placeholder: "Enter Name",
                    minimumInputLength: 2,
                    allowClear: true,
                    tags: true,
                    ajax: {
                        url: "{{ route('ajaxSearchEmployee') }}",
                        dataType: 'json',
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: function(term) {
                            return {
                                term: term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.userName,
                                        id: item.userName,
                                    }
                                })
                            };
                        }
                    },
                    dropdownCssClass: "bigdrop",
                });
            });

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
