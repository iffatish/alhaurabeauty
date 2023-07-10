<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\User;
use App\Models\Team;
use App\Models\RestockInformation;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TeamController extends Controller
{
    public function viewTeamList()
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $team = Team::get();
            $team_lead = Team::where('teamLeader', Auth::id())->first();

            $team_member_arr = array();
            $team_list_current_user = collect();

            foreach($team as $i => $data){

                $team_member_arr[$i] = array();
                $team_member_arr[$i] = preg_split("/[\s,]+/", $data->teamMember);

                if(in_array(Auth::id(), $team_member_arr[$i])){
                    $team_list_current_user->push($data);
                }
            }

            return view('TeamManagementModule.view_team_list')->with(['user'=> $user, 'team'=> $team_list_current_user, 'team_lead' => $team_lead]);
        }
        return redirect('login');
    }

    public function viewCreateTeam()
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();

            return view('TeamManagementModule.create_team')->with('user', $user);
        }
        return redirect('login');
    }

    public function createTeam(Request $request)
    {
        if(Auth::check())
        {
            $request->validate([
                'teamName' => 'required',
                'teamDesc' => 'required'
            ]);
    
            $data = $request->all();

            $saved = Team::create([
                'teamName' => $data['teamName'],
                'teamLeader' => Auth::id(),
                'teamDesc' => $data['teamDesc'],
                'dateCreated' => date('Y-m-d'),
                'memberNum' => 1,
                'teamMember' => Auth::id()
            ]);
    
            $user = User::where('id', Auth::id())->first();
            $team = Team::get();
            $team_lead = Team::where('teamLeader', Auth::id())->first();

            $team_member_arr = array();
            $team_list_current_user = collect();

            foreach($team as $i => $data){

                $team_member_arr[$i] = array();
                $team_member_arr[$i] = preg_split("/[\s,]+/", $data->teamMember);

                if(in_array(Auth::id(), $team_member_arr[$i])){
                    $team_list_current_user->push($data);
                }
            }

            return redirect('view_team_list')->with(['user'=> $user, 'team'=> $team_list_current_user, 'team_lead' => $team_lead, 'success' => 'Team successfully created!']);
        }
        return redirect('login');
    }

    public function viewTeamDetails(Request $request)
    {
        if(Auth::check())
        {
            $teamId_session = $request->session()->get('teamId');
            $teamId_parameter = $request->teamId;

            if(isset($teamId_session))
            {
                $team = Team::where('teamId', $teamId_session)->first(); 
            }else{
                $team = Team::where('teamId', $teamId_parameter)->first(); 
            }
            
            $user = User::where('id', Auth::id())->first();

            return view('TeamManagementModule.view_team_details')->with(['user'=> $user, 'team'=> $team, 'teamId' => $team->teamId]);
        }
        return redirect('login');
    }

    public function viewTeamMember(Request $request)
    {
        if(Auth::check())
        {

            $team = Team::where('teamId', $request->teamId)->first();
            
            $user = User::where('id', Auth::id())->first();

            $team_member_list = array();

            if($team->teamMember) { 
                $team_member_list = preg_split("/[\s,]+/", $team->teamMember);
            }

            $teamMember = collect();

            foreach($team_member_list as $data){
                $member = User::where('id', $data)->first();

                $teamMember->push($member);
            }
            
            return view('TeamManagementModule.view_team_member')->with(['user'=> $user, 'team'=> $team, 'teamMember'=> $teamMember]);
        }
        return redirect('login');
    }

    public function viewUpdateTeam(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $team = Team::where('teamId', $request->teamId)->first();

            return view('TeamManagementModule.update_team')->with(['user'=> $user, 'team'=> $team]);
        }
        return redirect('login');
    }

    function updateTeam(Request $request)
    {
        if(Auth::check())
        {
            $request->validate([
                'teamName' => 'required',
                'teamDesc' => 'required'
            ]);
    
            $data = $request->all();

            $saved = Team::where('teamId', $request->teamId)
                        ->update([
                            'teamName' => $data['teamName'],
                            'teamDesc' => $data['teamDesc']
                        ]);

            $user = User::where('id', Auth::id())->first();
            $team = Team::where('teamId', $request->teamId)->first();

           if($saved){
                return redirect()->route('view_team_details', ['teamId'=> $request->teamId])->with('success', 'Team successfully updated!');
            }else{
                return redirect()->route('update_team', ['teamId'=> $request->teamId]);
            }
        }
        return redirect('login');
    }

    public function viewAddTeamMember(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $team = Team::where('teamId', $request->teamId)->first();

            return view('TeamManagementModule.add_team_member')->with(['user'=> $user, 'team'=> $team]);
        }
        return redirect('login');
    }

    function addTeamMember(Request $request)
    {
        if(Auth::check())
        {
            $request->validate([
                'teamMemberId' => 'required'
            ]);
    
            $data = $request->all();

            //check team member
            $all_team = Team::get();

            $team_member_list = array();
            $all_team_member_list = array();

            foreach($all_team as $bil => $t){

                $team_member_list = preg_split("/[\s,]+/", $t->teamMember);
                $all_team_member_list[$bil] = $team_member_list;

            }

            foreach($all_team as $bill => $a_t){
                if(in_array($request->teamMemberId, $all_team_member_list[$bill]) && ($a_t->teamLeader != $request->teamMemberId)){
                    return redirect()->route('add_team_member', ['teamId'=> $request->teamId])->with('error', 'ERROR! The user already belongs to another team.');
                }
            }

            $teamMember = Team::where('teamId', $request->teamId)->value('teamMember');
            $memberNum = Team::where('teamId', $request->teamId)->value('memberNum');
            $updated_teamMember = $teamMember .",".$data['teamMemberId'];
            $memberNum += 1;

            $saved = Team::where('teamId', $request->teamId)
                        ->update([
                            'teamMember' => $updated_teamMember,
                            'memberNum' => $memberNum
                        ]);

            $user = User::where('id', Auth::id())->first();

           if($saved){
                return redirect()->route('view_team_member', ['teamId'=> $request->teamId])->with('success', 'Team member successfully added!');
            }else{
                return view('TeamManagementModule.add_team_member', ['teamId'=> $request->teamId]);
            }
        }
        return redirect('login');
    }

    public function viewTeamRestock(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $team = Team::where('teamId', $request->teamId)->first();
            $restock = RestockInformation::orderBy('restockDate','DESC')->get();
            $product = Product::get();

            $team_restock = collect();
            $team_member_list = array();
            if($team->teamMember) { 
                $team_member_list = preg_split("/[\s,]+/", $team->teamMember);
            }

            foreach($restock as $data){
                if(in_array($data->employeeId, $team_member_list))
                {
                    $team_restock->push($data);
                }
            }

            $total_items = array();
            $product_restock = array();
            foreach($team_restock as $i => $data2)
            {
                $product_restock[$i] = collect();
                $k = 0;
                foreach($product as  $j => $data3)
                {
                    $col = $data3->productId . "_restock_qty";
                    if($data2->$col != 0){
                        $total_items[$i][$k++] = $data2->$col; 
                        $product_restock[$i]->push($data3);
                    }
                } 
            }
            
            return view('TeamManagementModule.view_team_restock')->with([
                                                                    'user'=> $user,
                                                                    'team'=> $team,
                                                                    'team_restock' => $team_restock,
                                                                    'product_restock' => $product_restock,
                                                                    'total_items' => $total_items
                                                                    ]);
        }
        return redirect('login');
    }

    public function viewTeamRestockGraph(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            $team = Team::where('teamId', $request->teamId)->first();

            $team_member_list = array();
            if($team->teamMember) { 
                $team_member_list = preg_split("/[\s,]+/", $team->teamMember);
            }

            $k=0;
            $total_restock[] = ['Team Member','Restock Price (RM)'];
            foreach($team_member_list as $i => $data){
                $member = User::where('id',$data)->first();
                $team_restock_price = RestockInformation::where('employeeId',$data)
                                                        ->whereMonth('restockDate', Carbon::now()->month)
                                                        ->sum('restockPrice');
                                                                                           
                $total_restock[++$k] = [$member->userName, (double)($team_restock_price)];
            }
        
            $month = Carbon::now()->format('F');
            $year = Carbon::now()->year;

            return view('TeamManagementModule.view_team_restock_statistical_graph', compact('total_restock'))->with([
                                                                                        'user'=> $user,
                                                                                        'team'=> $team,
                                                                                        'month'=> $month,
                                                                                        'year'=> $year
                                                                                    ]);
        }
        return redirect('login');
    }

    public function updateChart(Request $request) {

        if(Auth::check())
        {
       
            $year = Carbon::parse($request->year_month)->format('Y');
            $month = Carbon::parse($request->year_month)->format('m');

            $user = User::where('id', Auth::id())->first();
            $team = Team::where('teamId', $request->teamId)->first();

            $team_member_list = array();
            if($team->teamMember) { 
                $team_member_list = preg_split("/[\s,]+/", $team->teamMember);
            }

            $k=0;
            $total_restock[] = ['Team Member','Restock Price (RM)'];
            foreach($team_member_list as $i => $data){
                $member = User::where('id',$data)->first();
                $team_restock_price = RestockInformation::where('employeeId',$data)
                                                        ->whereYear('restockDate', $year)
                                                        ->whereMonth('restockDate', $month)
                                                        ->sum('restockPrice');

                $total_restock[++$k] = [$member->userName, (int)$team_restock_price];
            }
        
            $month = Carbon::parse($request->year_month)->format('F');

            return view('TeamManagementModule.view_team_restock_statistical_graph', compact('total_restock'))->with([
                                                                                        'user'=> $user,
                                                                                        'team'=> $team,
                                                                                        'month'=> $month,
                                                                                        'year'=> $year
                                                                                    ]);
        }
        return redirect('login');                                                                        
    }

    public function removeTeamMember(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            
            $data = $request->id;
            $data_arr = array();
            $data_arr = preg_split("/[\s,]+/", $data);
            
            $team = Team::where("teamId", $data_arr[1])->first();
            $team_member = array();
            $team_member = preg_split("/[\s,]+/", $team->teamMember);

            foreach($team_member as $i => $t)
            {
                if($data_arr[0] == $t){
                    array_splice($team_member, $i, 1);
                } 
            }

            $total = count($team_member);
            $last_index = $total - 1;
            $new_team_member = "";
            foreach($team_member as $k => $t_m)
            {
                if($k == $last_index) {
                    $new_team_member .= $t_m;
                }else{
                    $new_team_member .= $t_m.",";
                }      
            }
            
            $saved = Team::where('teamId', $data_arr[1])
                        ->update([
                            'teamMember' => $new_team_member,
                            'memberNum' => $total
                        ]);
            
            // check data deleted or not
            if ($saved) {
                $success = true;
                $message = "Member removed successfully";
            } else {
                $success = true;
                $message = "Member not found";
            }

            //  return response
            return response()->json([
                'success' => $success,
                'message' => $message,
            ]);
            
        }
        return redirect('login');
    }

    public function leaveTeam(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            
            $teamId = $request->teamId;
            
            $team = Team::where('teamId', $teamId)->first();
            
            if($team->teamLeader != Auth::id())
            {
                $team_member = array();
                $team_member = preg_split("/[\s,]+/", $team->teamMember);

                foreach($team_member as $i => $t)
                {
                    if(Auth::id() == $t){
                        array_splice($team_member, $i, 1);
                    } 
                }

                $total = count($team_member);
                $last_index = $total - 1;
                $new_team_member = "";
                foreach($team_member as $k => $t_m)
                {
                    if($k == $last_index) {
                        $new_team_member .= $t_m;
                    }else{
                        $new_team_member .= $t_m.",";
                    }      
                }

                $saved = Team::where('teamId', $teamId)
                        ->update([
                            'teamMember' => $new_team_member,
                            'memberNum' => $total
                        ]);
            }
            else
            {
                $saved = Team::where('teamId', $teamId)->delete();
            }

            // check data deleted or not
            if ($saved) {
                $success = true;
                $message = "Successfully leave from the team";
            } else {
                $success = true;
                $message = "Unable to leave team";
            }

            //  return response
            return response()->json([
                'success' => $success,
                'message' => $message,
            ]);
            
        }
        return redirect('login');
    }

    public function deleteTeam(Request $request)
    {
        if(Auth::check())
        {
            $user = User::where('id', Auth::id())->first();
            
            $teamId = $request->teamId;
            
            $saved = Team::where('teamId', $teamId)->delete();

            // check data deleted or not
            if ($saved) {
                $success = true;
                $message = "Team deleted successfully";
            } else {
                $success = true;
                $message = "Unable to delete team";
            }

            //  return response
            return response()->json([
                'success' => $success,
                'message' => $message,
            ]);
            
        }
        return redirect('login');
    }

    //AJAX

    public function searchEmployee(Request $request) {
       
        $input = $request->all();

        $employee = User::where('userName', 'Like', '%' . $input['term']['term'] . '%')
                    ->get()
                    ->toArray();

        return response()->json($employee);
    }

}
