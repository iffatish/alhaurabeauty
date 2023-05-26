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
            .team-btn button{
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
                margin-top: 1.25rem;
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
            .team-menu td{
                padding-top: 1.25rem;
                padding-bottom: 1.25rem;
                background-color: white;
            }
            .team-menu tr:first-of-type td:first-of-type{
                border-top-left-radius: 1.875rem;
            }
            .team-menu tr:first-of-type td:last-of-type{
                border-top-right-radius: 1.875rem;
            }
            .team-menu tr:last-of-type td:first-of-type {
                border-bottom-left-radius: 1.875rem;
            }
            .team-menu tr:last-of-type td:last-of-type {
                border-bottom-right-radius: 1.875rem;
            }
            .input-title{
                padding-left: 3.125rem;
                font-weight: bold;
            }
            .team td{
                padding: 0.938rem;
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
            h1{
                color: #FF2667;
                padding: 0;
            }
            .team-menu{
                position: absolute;
                top:17.5rem;
                right:1.875rem;
                font-size: 0.875rem;
            }
            .team-menu td{
                padding: 0.938rem 0.938rem;
                text-align: center;
                background-color: #FF2667;
                box-shadow: 0 0.125rem 0.063rem black;
                cursor: pointer;
                border-bottom: 0.063rem solid white;
            }
            .team-menu td:hover{
                background-color: #871437;
            }
            .team-menu a{
                color:white;
                text-decoration: none;
            }
            .team-menu a:link{
                text-decoration:none;
            }
            .message{
                position:fixed;
                background-color:#C1E1C1;
                color:#023020;
                padding:15px;
                box-shadow: 0 0.125rem 0.063rem black;
            }
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

        @if ($message = Session::get('success'))
        <div class="message" id="message">
            <span>{{ $message }}</span>
            <a href="javascript:close()"><i class="fa fa-times"></i></a>
        </div>
        @endif

        <div class="team-btn" style="margin: 3.125rem 0 1.25rem 6.25rem;">
            <a href="{{route('view_team_list')}}"><button style="color: white;background-color:#FF2667;">Back to Team List</button></a>
        </div>

        <div class="center">
            <h1>Team Member</h1>
        </div>

        <div class="content">
            <table width="100%">
                <tr>
                    <th width="10%" style="border-right: 0.063rem solid white">No.</th>
                    <th style="border-right: 0.063rem solid white">Name</th>
                    <th style="border-right: 0.063rem solid white">Position</th>
                    @if(Auth::id() == $team->teamLeader)
                        <th width="17%" style="border-right: 0.063rem solid white">Sales Report</th>
                        <th width="12%">Remove</th>
                    @endif
                </tr>
                @if($teamMember)
                    @foreach($teamMember as $i=> $teamMember)
                    <tr class="team">
                        <td style="padding: 0;text-align:center; border-right: 0.063rem solid #E8E8E8">{{$i + 1}}</td>
                        <td style="border-right: 0.063rem solid #E8E8E8">{{$teamMember->userName}} @if($i == 0)<span style="color: #FF2667">(LEADER)</span>@endif</td>
                        @if(Auth::id() == $team->teamLeader)
                            <td style="border-right: 0.063rem solid #E8E8E8">{{$teamMember->userPosition}}</td>
                            <td class="view" style="padding: 0;text-align:center; border-right: 0.063rem solid #E8E8E8"><a href="">view</a></td>
                            <td class="view" style="padding: 0;text-align:center;"><a href=""><i class="fa fa-user-minus"></i></a></td>
                        @else
                            <td style="padding: 0;text-align:center;">{{$teamMember->userPosition}}</td>
                        @endif
                    </tr>
                    @endforeach
                @else
                <tr class="team center">
                    <td colspan="4">No results found</td>
                </tr>
                @endif
            </table>
        </div>

        <div class="team-menu">
            <table>
                <tr><td><a href="{{route('view_team_details', ['teamId' => $team->teamId])}}">View Team Details</a></td></tr>
                <tr><td><a href="{{route('view_team_restock_graph', ['teamId' => $team->teamId])}}">View Team’s Restock Items Statistical Graph</a></td></tr>
                <tr><td><a href="{{route('view_team_restock', ['teamId' => $team->teamId])}}">View Team Restock Information</a></td></tr>
                <tr><td style="background-color:#871437;"><a href="{{route('view_team_member', ['teamId' => $team->teamId])}}">View Team Members</a></td></tr>
                @if(Auth::id() != $team->teamLeader)
                    <tr><td style="background-color:#B8B8B8;cursor:not-allowed"><a href="" style="cursor:not-allowed;">Add Team Member</a></td></tr>
                @else
                    <tr><td><a href="{{route('add_team_member', ['teamId' => $team->teamId])}}">Add Team Member</a></td></tr>
                @endif
                @if(Auth::id() != $team->teamLeader)
                    <tr><td style="background-color:#B8B8B8;cursor:not-allowed"><a href="" style="cursor:not-allowed;">Update Team</a></td></tr>
                @else
                    <tr><td><a href="{{route('update_team', ['teamId' => $team->teamId])}}">Update Team</a></td></tr>
                @endif
                <tr><td><a href="">Leave Team</a></td></tr>
                @if(Auth::id() != $team->teamLeader)
                    <tr><td style="border:none;background-color:#B8B8B8;cursor:not-allowed"><a href="" style="cursor:not-allowed;">Delete Team</a></td></tr>
                @else
                    <tr><td style="border:none;"><a href="">Delete Team</a></td></tr>
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
