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
            .right{
                text-align: right;
                padding-right: 50px;
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
            tr:first-of-type th:first-of-type {
                border-top-left-radius: 30px;
            }
            tr:first-of-type th:last-of-type{
                border-top-right-radius: 30px;
            }
            tr:last-of-type td:first-of-type {
                border-bottom-left-radius: 30px;
            }
            tr:last-of-type td:last-of-type {
                border-bottom-right-radius: 30px;
            }
            .input-title{
                text-align: center;
                background-color: #FF2667;
                color: white;
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
                width: 150px;
                border-radius: 4px;
            }
            .image{
                border: 1px solid #dfdfdf;
            }
            .current-user{
                padding-right: 1.563rem;
                color: dimgrey;
            }
            .table-dc tr:first-of-type td:first-of-type {
                border-top-left-radius: 0;
            }
            .table-dc tr:first-of-type td:last-of-type{
                border-top-right-radius: 0;
            }
            .table-dc tr:last-of-type td:first-of-type {
                border-bottom-left-radius: 0;
            }
            .table-dc tr:last-of-type td:last-of-type{
                border-bottom-right-radius: 0;
            }

            .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
            }

            /* Hide default HTML checkbox */
            .switch input {display:none;}

            /* The slider */
            .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            }

            .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            }

            input:checked + .slider {
            background-color: #40bf40;
            }

            input:focus + .slider {
            box-shadow: 0 0 1px #40bf40;
            }

            input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
            }

            /* Rounded sliders */
            .slider.round {
            border-radius: 34px;
            }

            .slider.round:before {
            border-radius: 50%;
            }

            #add{
                color: white;
                background-color: #40bf40;
                border: none;
                cursor: pointer;
            }
            input[type=text], input[type=number] {
                width: 200px;
                height: 30px;
                padding: 5px 5px;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }
            .reset a{
                text-decoration: none;
                color:#FF2667;
            }
            .reset a:link{
                text-decoration:none;
            }
            .reset a:hover{
                color: #FF2667;
                text-decoration:underline;
            }
            .reset a:active {
                text-decoration: #FF2667;
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
            <a href="{{route('view_stock')}}"><button>View Products</button></a>
            @if($user->userPosition == "HQ")
                <a href="{{route('add_product')}}"><button>Add New Product</button></a>
                <a href="{{route('view_discount')}}"><button style="color:#FF2667 ;background-color:white;border: 3px solid #FF2667">Discount</button></a>
            @endif
            <a href="{{route('restock_product')}}"><button>Restock</button></a>
            <a href="{{route('view_restock_list')}}"><button>View Restock</button></a>
        </div>

        <div class="content">
            <form method="post" action="{{route('update_product_discount')}}" enctype="multipart/form-data" id="form_update">
            @csrf
                <table width="100%">
                    <tr>
                        <th>Update Product Discount</th><th></th>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding:30px">
                            <table id="table-dc" class="table-dc center" width="100%" border="1">
                                <tr>
                                    <td class="input-title">Discount Name</td><td class="input-title" >Discount (%)</td><td class="input-title">Active</td><td class="input-title" style="background-color: #40bf40;"><button id="add"><i class='fa fa-plus'></i></button></td>
                                </tr>
                                @if($discount->count() > 0)
                                    @foreach($discount as $bil => $disc)
                                            @php 
                                                $row = "row" . ($bil + 1);
                                            @endphp
                                            <tr id="{{$row}}">
                                                <input type="hidden" name="id[]" value="{{$disc->prodDiscId}}">
                                                <input type="hidden" name="flag[]" value="0">
                                                <td><input name="name[]" type="text" value="{{$disc->discountName ?? ''}}"></td>
                                                <td><input name="disc[]" type="number" step=".01" value="{{$disc->productDiscount ?? ''}}"></td>
                                                <td><label class="switch"><input type="radio" name="switch[]" value="{{$bil}}" @if($disc->status == 1) checked @else @endif><span class="slider round"></span></label></td>
                                                <td><button id="{{$bil + 1}}" style="padding:5px;background: none;color:red;border: none;cursor: pointer;" class="remove_row"><i class="fa fa-times"></i></button></td>
                                            </tr>
                                    @endforeach
                                @else
                                    <tr id="row1">
                                        <input type="hidden" name="id[]" value="0">
                                        <input type="hidden" name="flag[]" value="1">
                                        <td><input name="name[]" type="text" required></td>
                                        <td><input name="disc[]" type="number" step=".01" required></td>
                                        <td><label class="switch"><input type="radio" name="switch[]" value="0"><span class="slider round"></span></label></td>
                                        <td><button id="1" style="padding:5px;background: none;color:red;border: none;cursor: pointer;" class="remove_row"><i class="fa fa-times"></i></button></td>
                                    </tr>
                                @endif   
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="center reset" colspan="2"><a  href="javascript:resetActive();">Reset Active</a></td>
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
                        <td colspan="2" style="padding-bottom:40px;"class="center back"><button class="save" type="submit" form="form_update" value="Save"><i class='fa fa-save'></i>&nbsp;&nbsp;Save</button><br><br><a href="{{route('view_product_discount')}}">Cancel</a></td>
                    </tr>
                </table>
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

            $(document).ready(function(){
                $("#add").click(function(e){

                    e.preventDefault();
                    var i = $("#table-dc tr").length - 1;
                    $("#table-dc").append(`<tr id="row`+(i+1)+`"><input type="hidden" name="id[]" value="0"><input type="hidden" name="flag[]" value="1"><td><input name="name[]" type="text" required></td><td><input name="disc[]" type="number" step=".01" required></td><td><label class="switch"><input type="radio" name="switch[]" value="`+i+`"><span class="slider round"></span></label></td><td><button id="`+(i+1)+`" style="padding:5px;background: none;color:red;border: none;cursor: pointer;" class="remove_row"><i class="fa fa-times"></i></button></td></tr>`);
                });

                $(document).on('click','.remove_row', function(e){

                    e.preventDefault();
                    var row_id = $(this).attr("id");
                    var flag = $("#row"+row_id).find("[name='flag[]']").val();

                    //flag = 0 -> data exist
                    //flag = 1 -> new row
                    //flag = 2 -> will be deleted
                    
                    if(flag == 0){
                        $("#row"+row_id).find("td").css("background-color","#ffcccc");
                        $("#row"+row_id).find("[name='flag[]']").val("2");
                    }else if(flag == 1){
                        $("#row"+row_id).remove();
                    }else if(flag == 2){
                        $("#row"+row_id).find("td").css("background-color","white");
                        $("#row"+row_id).find("[name='flag[]']").val("0");
                    }else{}
                        
                });
            });
            
            function resetActive(){
                $("[name='switch[]']").prop('checked', false);
            }
        </script>


    </body>
</html>