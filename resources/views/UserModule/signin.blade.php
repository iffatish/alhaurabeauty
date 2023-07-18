<!DOCTYPE html>
<html>
    <head>
        <title>ABSMS</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <style>
            body {
                font-family: 'Open Sans', sans-serif;
                background-color: #FFE5F0;
            }
            .white-top{
                background-color: white;
                width: 100%;
                padding: 0.625rem 0;
                text-align: center;
                box-shadow: 0 0.188rem 0.188rem grey;
            }
            .content{
                width: 60%;
                margin: auto;
                margin-top: 6.25rem;
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
            }
            th{
                padding: 0.938rem 0;
                font-size: 1.5rem;
                font-weight: bold;
                color: #FF2667;
                background-color: white;
            }
            .welcome{
                text-align: center;
                background-color: #FF2667;
                border-bottom-right-radius: 1.875rem;
                color: white;
                font-size: 1.25rem;
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
            }
            input[type=email], input[type=text], input[type=password] {
                width: 80%;
                height: 1.875rem;
                padding: 0.313rem 0.313rem;
                display: inline-block;
                border: 0.063rem solid #ccc;
                border-radius: 0.25rem;
                box-sizing: border-box;
            }
            input[type=submit]{
                color: white;
                background-color: #FF2667;
                border: none;
                padding: 0.625rem 1.25rem;
                font-size: 1.125rem;
                border-radius: 1.875rem;
                font-weight: bold;
                box-shadow: 0 0.125rem 0.063rem black;
                cursor: pointer;
            }
            a{
                color: #FF2667;
            }
            a:link{
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
            .message{
                position:fixed;
                background-color:#C1E1C1;
                color:#023020;
                padding:15px;
                box-shadow: 0 0.125rem 0.063rem black;
            }
            .message a{color:black;}
            .message a:hover{cursor:pointer;}
        </style>
    </head>
    <body>

        <div class="white-top"><img src="images/logoalhaura.jpg" height="80" width="auto"></div>

        @if ($message = Session::get('success'))
        <div class="message" id="message">
            <span>{{ $message }}</span>
            <a href="javascript:close()"><i class="fa fa-times"></i></a>
        </div>
        @endif

        <div class="content">
            <table width="100%">
                <form method="post" action="{{ route('user.validate_login') }}">
                    @csrf
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <tr>
                        <th colspan="2"><b>Login</b></th>
                        <td rowspan="5" class="welcome" width="50%" style="padding:0 0.313rem;">
                            Welcome to
                            <br>
                            <br>
                            <hr style="height:0.063rem;width:60%;color:white;background-color:white;">
                            <br>
                            <b style="font-size:1.125rem;">ALHAURA BEAUTY SALES MANAGEMENT SYSTEM</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 0.625rem;">@if ($errors->any())
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
                        <td class="input-title"><label>Email <span style="color:red;">*</span></label><br><br><input required name="email" type="email"></td>
                    </tr>
                    <tr>
                        <td class="input-title"><label>Password <span style="color:red;">*</span></label><br><br><input required name="password" type="password" id="id_password"><i class="fa fa-eye" id="togglePassword" style="margin-left:0.625rem;cursor: pointer;"></i></td>
                    </tr>
                    <tr>
                        <td class="center"><input type="submit" value="Login"><br><br>Don’t have an account? <a href="{{route('registration')}}"><b>Register now!</b></a><br><br></td>
                    </tr>
                </form>
            </table>
        </div>
        
        <script>
            $('#togglePassword').click(function (e) {
            
                e.preventDefault();

                const type = $('#id_password').attr('type') === 'password' ? 'text' : 'password';
                $('#id_password').attr('type', type);
                
                $('#togglePassword').toggleClass('fa-solid fa-eye-slash');
                
            });

            function close() {
                var x = document.getElementById("message");
                x.style.display = "none";
            }
        </script>
    </body>
</html>
