<!DOCTYPE html>
<html>
    <head>
        <title>ABSMS</title>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'></link> 
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
        <script type="text/javascript">
            google.charts.load('current',{'packages':['bar']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable({{ Js::from($total_restock) }});
                
                var options = {
                    chart: {
                        title: 'Total (RM)'
                    },
                };

                var formatter = new google.visualization.NumberFormat({decimalSymbol: '.'});
                formatter.format(data, 1);

                var chart = new google.charts.Bar(document.getElementById('restockChart'));

                chart.draw(data, google.charts.Bar.convertOptions(options));
            }
        </script>

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
                height: 50%;
                margin: auto;
                margin-top: 1.25rem;
                margin-bottom: 6.25rem;
                background-color: white;
                padding: 1.25rem;
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
            input[type=month]{
                font-family: 'Open Sans', sans-serif;
                width: 9.375rem;
                height: 1.875rem;
                padding: 0.313rem 0.313rem;
                display: inline-block;
                border: 0.063rem solid #ccc;
                border-radius: 0.25rem;
                box-sizing: border-box;
            }
            input[type=submit]{
                font-family: 'Open Sans', sans-serif;
                color: white;
                background-color: #FF2667;
                border: none;
                padding: 0.313rem 1.25rem;
                border-radius: 0.25rem;
                cursor: pointer;
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

        <div class="team-btn" style="margin: 3.125rem 0 1.25rem 6.25rem;">
            <a href="{{route('view_team_list')}}"><button style="color: white;background-color:#FF2667;">Back to Team List</button></a>
        </div>

        <div class="center">
            <h1>Team's Restock Items Statistical Graph</h1>
        </div>

        <div class="content">
            <form method="post" action="{{route('update_team_restock_graph', ['teamId' => $team->teamId])}}">
                @csrf
                <input name="year_month" id="year_month" type="month">
                <input type="submit" value="Search">
            </form>
            <div style="text-align:center;margin: 2.5rem 0 1.25rem 0;font-size:1.125rem;">{{$month}}, {{$year}}</div>
            <div id="restockChart"></div>
        </div>

        <div class="team-menu">
            <table>
                <tr><td><a href="{{route('view_team_details', ['teamId' => $team->teamId])}}">View Team Details</a></td></tr>
                <tr><td style="background-color:#871437;"><a href="{{route('view_team_restock_graph', ['teamId' => $team->teamId])}}">View Team’s Restock Items Statistical Graph</a></td></tr>
                <tr><td><a href="{{route('view_team_restock', ['teamId' => $team->teamId])}}">View Team Restock Information</a></td></tr>
                <tr><td><a href="{{route('view_team_member', ['teamId' => $team->teamId])}}">View Team Members</a></td></tr>
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
                <tr><td><button id="{{$team->teamId}}" style="border: none;background: none;cursor: pointer;margin: 0;padding: 0;color:white;font-size: 0.875rem;" onclick="leaveTeam(this.id)" type="button" data-link="{{route('view_team_list')}}">Leave Team</button></td></tr>
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

            function leaveTeam(id){
                var link = $(this).data("link");
                swal.fire({
                    html: "<b>Are you sure you want to <span style='color:#FF2667'>leave</span> this team?</b>",
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    confirmButtonColor: '#FF2667',
                }).then(function (e) {

                    if (e.value === true) {
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                        $.ajax({
                            type: 'POST',
                            url: "/leave_team/" + id,
                            data: {_token: CSRF_TOKEN},
                            dataType: 'JSON',
                            success: function (results) {
                                if (results.success === true) {
                                    swal.fire({
                                        icon: "success",
                                        title: "Done!",
                                        text: results.message,
                                        confirmButtonColor: '#FF2667',
                                        allowOutsideClick: false
                                    });
                                    // refresh page after 2 seconds
                                    setTimeout(function(){
                                        window.location.href = link;
                                    },3000);
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
                })
            }
        </script>


    </body>
</html>
