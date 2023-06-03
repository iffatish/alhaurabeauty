<!DOCTYPE html>
<html>
    <head>
        <title>ABSMS</title>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
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
            .content{
                width: 45%;
                margin: auto;
                margin-top: 3.75rem;
                margin-bottom: 1.25rem;
            }
            .center{
                text-align: center;
            }
            table{
                border-collapse: collapse;
            }
            td{
                padding-top: 1.25rem;
                padding-bottom: 1.25rem;
                background-color: white;
                vertical-align: top;
            }
            tr:first-of-type td:first-of-type{
                border-top-left-radius: 1.875rem;
            }
            tr:first-of-type td:last-of-type{
                border-top-right-radius: 1.875rem;
            }
            tr:last-of-type td:first-of-type {
                border-bottom-left-radius: 1.875rem;
            }
            tr:last-of-type td:last-of-type {
                border-bottom-right-radius: 1.875rem;
            }
            .input-title{
                text-align: right;
                padding-right: 2.5rem;
                color: white;
                width: 40%;
                background-color: #FF2667;
                vertical-align: top;
            }
            .user-details{
                padding-left: 2.5rem;
                vertical-align: top;
                padding-right: 3.125rem;
            }
            .update{
                color: white;
                background-color: #FF2667;
                border: none;
                padding: 0.625rem 1.875rem;
                border-radius: 1.875rem;
                box-shadow: 0 0.125rem 0.063rem black;
                cursor: pointer;
            }
            .deactivate-div{
                text-align: center;
                margin-bottom: 5rem;
                margin-top: 40px;
                width:100%;
            }
            .deactivate-div button{
                color: #ff3333;
                border: 1px solid #ff3333;
                cursor: pointer;
                margin: 0;
                padding: 5px 15px;
                font-size: 17px;
                background-color: white;
            }
            .deactivate-div button:hover{
                background-color: #ff3333;
                color: white;
            }
            .update a{
                color: white;
            }
            .update a:link{
                text-decoration: none;
            }
            .update a:hover{
                text-decoration: none;
            }
            .update a:active {
                text-decoration: none;
            }
            .message{
                position:fixed;
                background-color:#C1E1C1;
                color:#023020;
                padding:15px;
                box-shadow: 0 0.125rem 0.063rem black;
            }
            .message a{color:black;}
            .message a:hover{cursor:pointer;}
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
                    <a href="{{route('view_stock')}}">STOCK</a>
                    @if($user->userPosition != "HQ")
                    <a href="{{route('view_team_list')}}">TEAM</a>
                    @endif
                </div>
            </div>
            <div class="dropdown" style="float:right;">
                <span class="current-user">{{$user->userName}} ({{$user->userPosition}})</span>
                <img class="user" src="images/user_pink.png" height="35" width="auto">

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

        <div class="content">
            <table width="100%">
                <tr>
                    <td class="input-title" style="padding-top: 4.375rem;">Name</td><td class="user-details" style="padding-top: 4.375rem;">{{$user->userName}}</td>
                </tr>
                <tr>
                    <td class="input-title">Phone Number</td><td class="user-details">{{$user->userPhoneNum}}</td>
                </tr>
                <tr>
                    <td class="input-title">Address</td><td class="user-details">{{$user->userAddress}}</td>
                </tr>
                <tr>
                    <td class="input-title">Job Position</td><td class="user-details">{{$user->userPosition}}</td>
                </tr>
                <tr>
                    <td class="input-title">Email</td><td class="user-details">{{$user->email}}</td>
                </tr>
                <tr>
                    <td class="input-title">Password</td><td class="user-details">{{$user->password}}</td>
                </tr>
                <tr>
                    <td class="input-title"></td><td class="center" style="padding-bottom: 3.125rem;"><a href="{{route('update_user')}}"><button class="update">Update</button></a></td>
                </tr>
            </table>
        </div>

        <div class="deactivate-div">
            <button id="{{$user->id}}" onclick="deactivateAccount(this.id)" type="button" data-link="{{route('login')}}">Deactivate Account</button>
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

            function deactivateAccount(id){

                var link = $("#"+id).data("link");
                swal.fire({
                    html: "<b>Are you sure you want to <span style='color:#FF2667'>deactivate</span> your account?</b>",
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    confirmButtonColor: '#FF2667',
                    allowOutsideClick: false,
                    backdrop: 'rgba(0,0,0,0.4)'
                }).then(function (e) {

                    if (e.value === true) {
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                        $.ajax({
                            type: 'POST',
                            url: "/deactivate_account/" + id,
                            data: {_token: CSRF_TOKEN},
                            dataType: 'JSON',
                            success: function (results) {
                                if (results.success === true) {
                                    swal.fire({
                                        icon: "success",
                                        title: "Done!",
                                        text: results.message,
                                        confirmButtonColor: '#FF2667',
                                        allowOutsideClick: false,
                                        backdrop: 'rgba(0,0,0,0.4)'
                                    });
                                    // refresh page after 2 seconds
                                    setTimeout(function(){
                                        window.location.href = link;
                                    },1500);
                                } else {
                                    swal.fire("Error!", results.message, "error");
                                }
                            }
                        });

                    } else {
                        e.dismiss;
                    }

                }, function (dismiss) {
                    return false;
                });
            }
            
            function close() {
                var x = document.getElementById("message");
                x.style.display = "none";
            }
        </script>


    </body>
</html>
