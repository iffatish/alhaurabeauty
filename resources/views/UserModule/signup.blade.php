<!-- sign up page. A page for user to register a new account -->
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
                vertical-align:top;
            }
            th{
                padding: 1.875rem 0 0.313rem 0;
                font-size: 1.5rem;
                font-weight: bold;
                color: #FF2667;
                background-color: white;
                vertical-align:top;
            }
            .register-button{
                text-align: center;
                background-color: #FF2667;
                border-bottom-right-radius: 1.875rem;
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
            input[type=text], input[type=email], input[type=password], input[type=number], select {
                width: 18.75rem;
                height: 1.875rem;
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
        </style>
    </head>
    <body>

        <div class="white-top"><img src="images/logoalhaura.jpg" height="80" width="auto"></div>

        <div class="content">
            <table width="100%">
                <form method="post" action="{{ route('user.validate_registration') }}">
                @csrf
                    <tr>
                        <th colspan="2"><b>Registration</b></th>
                        <td rowspan="9" style="vertical-align:middle;" class="register-button"><input type="submit" value="Register">
                        <br><br><a href="{{route('login')}}">Return to login</a></td>
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
                        <td width="30%" class="input-title">Name <span style="color:red;">*</span></td>
                        <td width="40%"><input required name="userName" type="text"></td>
                    </tr>
                    <tr>
                        <td class="input-title">Phone Number <span style="color:red;">*</span></td>
                        <td><input required name="userPhoneNum" type="number"></td>
                    </tr>
                    <tr>
                        <td class="input-title">Address <span style="color:red;">*</span></td><td><input required name="userAddress" type="text"></td>
                    </tr>
                    <tr>
                        <td class="input-title">Job Position <span style="color:red;">*</span></td>
                        <td>
                            <select name="userPosition" style="width:18.75rem;" required>
                                <option value="">Choose your position</option>
                                <option value="HQ">HQ</option>
                                <option value="Master Leader">Master Leader</option>
                                <option value="Leader">Leader</option>
                                <option value="Master Stockist">Master Stockist</option>
                                <option value="Stockist">Stockist</option>
                                <option value="Master Agent">Master Agent</option>
                                <option value="Agent">Agent</option>
                                <option value="Dropship">Dropship</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-title">Email <span style="color:red;">*</span></td><td><input  required name="email" type="email"></td>
                    </tr>
                    <tr>
                        <td class="input-title">Password <span style="color:red;">*</span></td>
                        <td><input required name="password" type="password" id="id_password">
                        <i class="fa fa-eye" id="togglePassword" style="margin-left:0.625rem;cursor: pointer;"></i></td>
                    </tr>
                    <tr>
                        <td class="input-title">Confirm Password <span style="color:red;">*</span></td>
                        <td><input required name="password_confirmation" type="password" id="id_confirm_password">
                        <i class="fa fa-eye" id="toggleConfirmPassword" style="margin-left:0.625rem;cursor: pointer;"></i><br><br><br></td>
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

        $('#toggleConfirmPassword').click(function (e) {
            
            e.preventDefault();

            const type = $('#id_confirm_password').attr('type') === 'password' ? 'text' : 'password';
            $('#id_confirm_password').attr('type', type);
            
            $('#toggleConfirmPassword').toggleClass('fa-solid fa-eye-slash');
        });
        </script>
    </body>
</html>
