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
                width: 70%;
                margin: auto;
                margin-top: 3.75rem;
                margin-bottom: 6.25rem;
                background-color:white;
                display: flex;
                padding: 1.875rem;
                border-radius: 1.875rem;
                flex-direction: row;
                justify-content: space-between;
            }
            .details{
                display: flex;
                flex-direction: row;
                justify-content: space-between;
            }
            .center{
                text-align: center;
            }
            table{
                border-collapse: collapse;
            }
            tr:first-of-type td:last-of-type{
                border-top-right-radius: 1.875rem;
            }
            tr:last-of-type td:first-of-type {
                border-bottom-left-radius: 1.875rem;
            }
            .first th{
                color: #FF2667;
                font-size: 1.5rem;
                padding-bottom: 0.938rem;
            }
            .first td{
                padding-bottom: 0.938rem;
                padding-right: 2.5rem;
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
            .error{
                background-color: #ffdbdb;
                color: red;
                padding: 0.313rem;
                border-radius: 0.938rem;
            }
            .input-title{
                padding-top:1rem;
                font-weight: bold;
            }
            input[type=text], input[type=number], input[type=date]{
                font-family: 'Open Sans', sans-serif;
                width: 18rem;
                height: 2rem;
                padding: 0.313rem 0.313rem;
                display: inline-block;
                border: 0.063rem solid #ccc;
                border-radius: 0.25rem;
                box-sizing: border-box;
            }
            .info {
                font-size: 0.875rem;
                color:#A9A9A9;
                font-weight: normal;
            }
            .back{
                font-size:12px;
            }
            .back a{
                text-decoration: none;
                color: black;
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
                border-radius: 4px;
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
                    <a href="{{route('view_order_list')}}" style="color:#FF2667">ORDER</a>
                    <a href="{{route('view_sales_report')}}">REPORT</a>
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

        <div class="stock-btn" style="margin: 3.125rem 6.25rem">
            <a href="{{route('view_order_list')}}"><button>View Order</button></a>
            <a href="{{route('add_order')}}"><button style="color:#FF2667 ;background-color:white;border: 0.188rem solid #FF2667">Add Order</button></a>
            
        </div>

        <form id="form_update" onsubmit="return addOrder();" method="post" action="{{route('add_order_save')}}">
        @csrf
        <div class="content">
            <div class="details">
                <div style="margin-right: 1.875rem;">
                    <table class="first">
                        <tr>
                            <th style="text-align:left;">New Order</th>
                        </tr>
                        <tr>
                            <td class="input-title">Order Date</td>
                        </tr>
                        <tr>
                            <td><input type="hidden" name="orderDate" value="{{date('d-m-Y')}}"><input type="text" name="orderDateStr" value="{{date('d-m-Y')}}" disabled></td>
                        </tr>
                        <tr>
                            <td class="input-title">Name <span style="color:red;">*</span></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="custName" required></td>
                        </tr>
                        <tr>
                            <td class="input-title">Phone Number <span style="color:red;">*</span></td>
                        </tr>
                        <tr>
                            <td><input type="number" name="custPhoneNum" required></td>
                        </tr>
                        <tr>
                            <td class="input-title">Delivery Address <span style="color:red;">*</span></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="deliveryAddress" required></td>
                        </tr>
                        <tr>
                            <td class="input-title">Delivery Method <span style="color:red;">*</span></td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="deliveryMethod" value="Postage" id="postage"><label for="postage">Postage</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="deliveryMethod" value="Cash-on-delivery" id="cod"><label for="cod">Cash-on-delivery</label>
                            </td>
                        </tr>
                        <tr>
                        <td class="input-title">Payment Method <span style="color:red;">*</span></td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="paymentMethod" value="Online payment" id="online"><label for="online">Online payment</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="paymentMethod" value="Cash" id="cash"><label for="cash">Cash</label>
                            </td>
                        </tr>
                        <tr>
                            <td class="input-title">Additional Cost (RM) <span style="color:red;">*</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="width: 11rem;" type="number" name="additionalCost" placeholder="Postage or COD fee" required></td>
                        </tr>
                    </table>
                </div>
                <div height="auto" width="0.063rem" style="border-left:1px solid #C8C8C8;"></div>
                <div style="padding-top:2.5rem;margin-left:30px;">
                    <table class="second" border="1">
                        <tr>
                        <th style="border-right: 0.063rem solid white">No.</th><th style="border-right: 0.063rem solid white">Item</th><th>Quantity</th>
                        </tr>
                        @if($product->count() < 1)
                        <tr>
                            <td colspan="3" class="center" style="color:Dimgrey;padding:1rem;">No products found</td>
                        </tr>
                        @endif
                        @foreach($product as $i => $product)
                        <tr>
                            <td class="center">{{$i +1}}</td>
                            @php
                                $product_qty_col = $product->productId . "_order_qty";
                            @endphp
                            <td>{{$product->productName}}</td><td><input class="amount" style="width:6.25rem;" required type="number" min="0" name="{{$product_qty_col}}" value="0" onchange="validateStock('{{$product->productId}}')"></td>
                        </tr>
                        @endforeach
                    </table>   
                </div>
            </div>
            <div class="center back" style="margin-top: auto;">
                <button class="save" type="submit" form="form_update" value="Add">+&nbsp;&nbsp;Add</button>
                <br><br>
                <a href="{{route('view_order_list')}}">Cancel</a>
            </div>
        </div>
    </form>

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
            
            function validateStock(id){
                
                var name = id + "_order_qty";

                $.ajax({
                    data: {
                        id_ : id
                    },
                    url: "{{route('ajaxValidateQuantityStock')}}",
                    type: "POST",
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        
                        if($('input[name='+ name + ']').val() > data)
                        {
                            alert("The product is out of stock!");
                            $('input[name='+ name + ']').val('0');
                            $('input[name='+ name + ']').focus();
                        }

                    },
                });
            }

            function addOrder() {

                let total = 0;

                $('.amount').each(function() {
                    total += $(this).val();
                })

                if(total == 0)
                {
                    alert("Please insert at least one item to add order!");
                    return false;
                }
                else{
                    return true;
                }
            }
        </script>


    </body>
</html>
