<!DOCTYPE html>
<html>
    <head>
        <title>ABSMS</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'></link> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
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
                margin-bottom: 3.75rem;
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
            }
            .save{
                font-family: 'Open Sans', sans-serif;
                color: white;
                background-color: #FF2667;
                border: none;
                padding: 0.625rem 1.875rem;
                border-radius: 1.875rem;
                box-shadow: 0 0.125rem 0.063rem black;
                cursor: pointer;
            }
            input[type=text], input[type=email], input[type=password], input[type=number], select {
                width: 18.75rem;
                height: 1.875;
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
            .error{
                font-size: 0.75rem;
                background-color: #ffdbdb;
                color: red;
                padding: 0.625rem;
                width: 80%;
                margin: auto;
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
                    <a href="">REPORT</a>
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

        <div>
        <div class="content">
            <table width="100%">
                <form id="form_update" action="{{route('user.update')}}" method="post">
                    @csrf
                    <tr>
                        <td class="input-title"></td>
                        <td colspan="2">@if ($errors->any())
                            <div class="error"> 
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>@endif
                        </td>
                    </tr>
                    <tr>
                        <td class="input-title" style="padding-top: 1.25rem;">Name</td><td class="user-details" style="padding-top: 1.25rem;"><input required name="userName" type="text" value="{{$user->userName}}"></td>
                    </tr>
                    <tr>
                        <td class="input-title">Phone Number</td><td class="user-details"><input required name="userPhoneNum" type="number" value="{{$user->userPhoneNum}}"></td>
                    </tr>
                    <tr>
                        <td class="input-title">Address</td><td class="user-details"><input required name="userAddress" type="text" value="{{$user->userAddress}}"></td>
                    </tr>
                    <tr>
                        <td class="input-title">Job Position</td>
                        <td class="user-details">
                            <select name="userPosition" required>
                                <option value="">Choose your position</option>
                                <option value="HQ" @if($user->userPosition == "HQ") selected @endif>HQ</option>
                                <option value="Master Leader" @if($user->userPosition == "Master Leader") selected @endif>Master Leader</option>
                                <option value="Leader" @if($user->userPosition == "Leader") selected @endif>Leader</option>
                                <option value="Master Stockist" @if($user->userPosition == "Master Stockist") selected @endif>Master Stockist</option>
                                <option value="Stockist" @if($user->userPosition == "Stockist") selected @endif>Stockist</option>
                                <option value="Master Agent" @if($user->userPosition == "Master Agent") selected @endif>Master Agent</option>
                                <option value="Agent" @if($user->userPosition == "Agent") selected @endif>Agent</option>
                                <option value="Dropship" @if($user->userPosition == "Dropship") selected @endif>Dropship</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-title">Email</td><td class="user-details"><input required name="email" type="email" value="{{$user->email}}"></td>
                    </tr>
                    <tr>
                        <td class="input-title">Password</td><td class="user-details"><input required name="password" type="password" value="{{$user->password}}" id="id_password"><i class="fa fa-eye" id="togglePassword" style="margin-left:0.625rem;cursor: pointer;"></i></td>
                    </tr>
                    <tr>
                        <td class="input-title">Confirm Password</td><td class="user-details"><input required name="password_confirmation" type="password" id="id_confirm_password"><i class="fa fa-eye" id="toggleConfirmPassword" style="margin-left:0.625rem;cursor: pointer;"></i></td>
                    </tr>
                    <tr>
                        <td class="input-title"></td><td style="padding-bottom:2.5rem;"class="center back"><button class="save" type="submit" form="form_update" value="Save"><i class='fa fa-save'></i>&nbsp;&nbsp;Save</button><br><br><a href="{{route('user.account')}}">Cancel</a></td>
                    </tr>
                </form>
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
            
            $('#togglePassword').click(function (e) {
            
                e.preventDefault();

                const type = $('#id_password').attr('type') === 'password' ? 'text' : 'password';
                $('#id_password').attr('type', type);
                
                $('#togglePassword').toggleClass('fa-solid fa-eye-slash');
            });

            $('#toggleConfirmPassword').click(function (e) {
                
                e.preventDefault();

                const type = $('#id_confirm_password').attr('type') === 'password' ? 'text' : 'password';
                $('#id_confirm_password').attr('type', type);
                
                $('#toggleConfirmPassword').toggleClass('fa-solid fa-eye-slash');
            });
        </script>


    </body>
</html>
