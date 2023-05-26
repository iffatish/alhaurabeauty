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
                padding-top: 1.25rem;
                padding-bottom: 1.25rem;
                background-color: white;
                vertical-align:top;
            }
            th{
                padding: 1.875rem 0 0.625rem 0.625rem;
                font-size: 1.5rem;
                font-weight: bold;
                color: #FF2667;
                background-color: white;
                vertical-align:top;
            }
            .create-button{
                text-align: center;
                background-color: #FF2667;
                border-bottom-right-radius: 1.875rem;
                font-size: 0.875rem;
            }
            th:first-of-type {
                border-top-left-radius: 1.875rem;
            }
            tr:first-of-type td:last-of-type{
                border-top-right-radius: 1.875rem;
            }
            tr:last-of-type td:first-of-type {
                border-bottom-left-radius: 1.875rem;
            }
            .input-title{
                padding-left: 3.125rem;
                font-weight: bold;
                font-size: 0.875rem;
            }
            input[type=text]{
                width: 17.5rem;
                height: 1.875rem;
                padding: 0.313rem 0.313rem;
                display: inline-block;
                border: 0.063rem solid #ccc;
                border-radius: 0.25rem;
                box-sizing: border-box;
            }
            textarea{
                font-family: 'Open Sans', sans-serif;
                width: 17.5rem;
                padding: 0.313rem 0.313rem;
                display: inline-block;
                border: 0.063rem solid #ccc;
                border-radius: 0.25rem;
                box-sizing: border-box;
            }
            input[type=submit]{
                font-family: 'Open Sans', sans-serif;
                color: #FF2667;
                background-color: white;
                border: none;
                padding: 0.625rem 1.25rem;
                font-size: 1.125rem;
                border-radius: 1.875rem;
                font-weight: bold;
                box-shadow: 0 0.125rem 0.063rem black;
                cursor: pointer;
                font-size: 0.875rem;
            }
            a{
                color: white;
            }
            a:link{
                text-decoration:none;
            }
            a:active{
                text-decoration:none;
            }
            a:hover{
                text-decoration: underline;
            }
            a:active {
                text-decoration: underline;
            }
            .error{
                background-color: #ffdbdb;
                color: red;
                padding: 0.313rem;
                border-radius: 0.938rem;
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

        <div class="stock-btn" style="margin: 3.125rem 6.25rem">
            <a href="{{route('view_team_list')}}"><button>View Team List</button></a>
            @if($user->userPosition != "Dropship")
                <a href="{{route('create_team')}}"><button style="color:#FF2667 ;background-color:white;border: 0.188rem solid #FF2667">Create Team</button></a>
            @endif
        </div>

        <div class="content">
            <table width="100%">
            <form method="post" action="{{ route('team.create') }}">
                @csrf
                    <tr>
                        <th colspan="2"><b>Create Team</b></th>
                        <td rowspan="5" style="vertical-align:middle;" class="create-button"><input type="submit" value="Create"><br><br><a href="{{route('view_team_list')}}">Cancel</a></td>
                    </tr>
                    <tr>
                        <td style="padding:0 0.625rem;" colspan="2">@if ($errors->any())
                            <div class="error">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td width="30%" class="input-title">Team Name</td><td width="40%"><input required name="teamName" type="text"></td>
                    </tr>
                    <tr>
                        <td class="input-title">Team Description</td><td><textarea id="w3review" name="teamDesc" rows="4" cols="50"></textarea></td>
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
        </script>


    </body>
</html>
