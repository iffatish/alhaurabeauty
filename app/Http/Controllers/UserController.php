<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Models\User;
use App\Models\ProductQuantity;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

//A controller that will handle all the functions related to user module.
class UserController extends Controller
{

    // A function that will direct user to home page if user is logged in. Else, it will direct user to login page.
    function home()
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();

            return view('UserModule.home')->with('user', $user);
        }
        return view('UserModule.signin');
    }

    //A funtion that will direct user to sign in page.
    function index()
    {
        return view('UserModule.signin');
    }

    // Afunction that will direct user to sign up page.
    function registration()
    {
        return view('UserModule.signup');
    }


    //A function that will validate the registration form and create a new user account if all input are valid. Else, it will direct user to sign up page.
    function validate_registration(Request $request)
    {
        $request->validate([
            'email' => 'required|email:rfc,dns|unique:employee,email',
            'userName' => 'required',
            'userPhoneNum' => 'required',
            'password' => 'required',
            'userAddress' => 'required',
            'userPosition' => 'required',
            'password_confirmation' => 'required|same:password'
        ]);

        $data = $request->all();

        $saved = User::create([
            'userName'  =>  $data['userName'],
            'userAddress' =>  $data['userAddress'],
            'userPhoneNum'  =>  $data['userPhoneNum'],
            'userPosition' =>  $data['userPosition'],
            'email' =>  $data['email'],
            'password' => $data['password']
        ]);

        $current_user = User::where('email', $data['email'])->first();
        ProductQuantity::create([
            'employeeId' => $current_user->id
        ]);

        $report_daily = (new ReportController)->createDailySalesReportNewUser($current_user);
        $report_monthly = (new ReportController)->createMonthlySalesReportNewUser($current_user);
        $report_yearly = (new ReportController)->createYearlySalesReportNewUser($current_user);

        return redirect('login')->with('success','Successful registration!');
    }

    //A function that will validate the login form and direct user to home page if all input are valid. Else, it will direct user to login page.
    function validate_login(Request $request)
    {
        $request->validate([
            'email' =>  'required',
            'password'  =>  'required'
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Email entered is not registered.',
            ]);
        }
  
        if($user){
            if(($request->input('password') === $user->password) && ($request->input('email') === $user->email))
            {
                Auth::login($user);
                return redirect('dashboard')->with(['userPosition' => $user->userPosition, 'success' => 'Successfully signed in!']);
                
            }else{
                throw ValidationException::withMessages([
                    'password' => 'Incorrect email or password.',
                ]);
            }
        }

    }

    //A function that will direct user to home page if user is logged in. Else, it will direct user to login page.
    function dashboard()
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();

            return view('UserModule.home')->with('user', $user);
        }
        return redirect('login');
    }

    //A function that will log out the user and direct user to login page.
    function logout()
    {
        Session::flush();

        Auth::logout();

        return redirect('login');
    }

    //A function that will direct user to view user account page if user is logged in. Else, it will direct user to login page.
    function viewUser()
    {

        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();

            return view('UserModule.view_user_account')->with('user', $user);
        }
        return redirect('login');
    }

    //A function that will direct user to update user account page if user is logged in. Else, it will direct user to login page.
    function viewUpdateUser()
    {

        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();

            return view('UserModule.update_user')->with('user', $user);
        }
        return redirect('login');
    }

    //A function that will validate the update user account form and update user account if all input are valid. If there is any input is invalid, it will direct user to update user account page.
    function updateUser(Request $request)
    {
        if(Auth::check())
        {
            $request->validate([
                'email' => ['required', 'string', 'email', Rule::unique('employee')->ignore(Auth::id())],
                'userName' => 'required',
                'userPhoneNum' => 'required',
                'password' => 'required',
                'userAddress' => 'required',
                'userPosition' => 'required',
                'password_confirmation' => 'required|same:password'
            ]);
    
            $data = $request->all();

            $user = User::where('id', Auth::id())->first();
            $saved = $user->update($request->all());                        

            if($saved){
                return redirect()->route('user.account')->with(['user' => $user, 'success' => 'Successfully updated!']);
            }else{
                return view('UserModule.update_user')->with('user', $user);
            }
        }
        return redirect('login');
    }

    //A function that will delete user account. If the user is a team leader of a team, the team will be deleted as well. If the user is a team member of a team, the user will be removed from the team.
    public function deactivateAccount(Request $request)
    {
        if(Auth::check())
        {
            $team = Team::where('teamLeader', Auth::id())->first();

            if($team){

                Team::where('teamId',$team->teamId)->delete();

            }
            
            $all_team = Team::get();

            foreach($all_team as $t){

                $team_member_list = preg_split("/[\s,]+/", $t->teamMember);
            
                foreach($team_member_list as $i => $t_l){
                
                    if($t_l == Auth::id()){
                        $delete_index = $i;
                    }
                }
                
                if(isset($delete_index)){
                    array_splice($team_member_list, $delete_index, 1);
                    
                    $total = count($team_member_list);
                    $last_index = $total - 1;
                    $new_team_member_list = "";

                    foreach($team_member_list as $j => $t_m)
                    {
                        if($j == $last_index) {
                            $new_team_member_list .= $t_m;
                        }else{
                            $new_team_member_list .= $t_m.",";
                        }      
                    }

                    Team::where('teamId',$t->teamId)->update([
                        'memberNum' => $total,
                        'teamMember' => $new_team_member_list
                    ]);
                }
            }

            $saved = User::where('id', Auth::id())->delete();

            // check data deleted or not
            if ($saved) {
                $success = true;
                $message = "Your account deactivated successfully";
            } else {
                $success = true;
                $message = "Unable to deactivate your account";
            }

            //  return response
            return response()->json([
                'success' => $success,
                'message' => $message,
            ]);
            
        }
        return redirect('login');
    }
}
