<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Character;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;


class UserController extends Controller
{
    public function hasRole($role)
    {
        return Auth::user()->role == $role;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // $users = User::all();
        return view('users');
        //return view('users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($userID = '')
    {
        if($userID=='')$user = Auth::user(); //check with middleware later
        else $user = User::findOrFail($userID);
        if(Gate::allows('show-user', $user)){
            $characters = Character::where('user_id', '=', $user->id)->get();
            return view('profile', ['characters' => $characters, 'Wuser' => $user]);
        }
        else redirect('profile');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $userID = '')
    {
        if($userID=='')$user = Auth::user();
        else $user = User::findOrFail($userID);
        if(Gate::allows('update-user', $user)){
            if($request->username != NULL){
                $validator = Validator::make($request->all(), [
                    'username' => 'required|unique:users,username'
                ]);
                if($validator->passes())$user->username = $request->username;
                else return redirect('profile')->withErrors($validator);
            } 
            if($request->email != NULL){
                $validator = Validator::make($request->all(), [
                    'email' => 'required|email:rfc,dns|unique:users,email'
                ]);
                if($validator->passes())$user->email = $request->email;
                else return redirect('profile')->withErrors($validator);
            } 
            if($request->password != NULL || $request->confirm_password != NULL){
                $validator = Validator::make($request->all(), [
                    'password' => 'required|min:8',
                    'password_confirmation' => 'required|same:password'
                ]);
                if($validator->passes())$user->password=$request->password;
                else return redirect('profile')->withErrors($validator);
            } 
            if($request->image != NULL){
                $validator = Validator::make($request->all(), [
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);
                if($validator->passes()){
                    if($user->profpic_path != NULL)File::delete(public_path('\assets\img').'/'.$user->profpic_path);
                    $request->image->move(public_path('\assets\img'), $request->image->getClientOriginalName());
                    $user->profpic_path=$request->image->getClientOriginalName();
                }
                else return redirect('profile')->withErrors($validator);
            } 
            if($request->active_character_id != NULL) $user->active_character_id=$request->active_character_id;
            $user->save();
        }
        return redirect('profile');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrfail($id);
        if(Gate::allows('delete-user', $user)){
            if(Auth::user()->id == $user->id) {
                app('App\Http\Controllers\LogoutController')->perform();
                $user->delete();
                return redirect("/register");
            }
            else{
                $user->delete();
                return redirect("/users");
            }
        } 
        
    }

    function search(Request $request){
    if($request->ajax()){
        //dd() - Don't use this thing here for debug, breaks everything.
        $query = $request->get('searchValue');
        $output = '';
        $loc = Session::get("locale");
            if($loc == 'ru'){
                $NDF = 'Информации не найдено.';
                $prof = "Открыть профиль";
            } 
            elseif($loc == 'en'){
                $NDF = 'No Data Found.';
                $prof = "View profile";
            } 
            else{
                $NDF = 'Informācija nav atrasta.';
                $prof = "Atvērt profilu";
            } 
        if($query != ''){
            $data = DB::table('users')
                            ->where('username', 'like', '%'.$query.'%')
                                ->orWhere('id', 'like', '%'.$query.'%')
                                    ->orderBy('id', 'ASC')
                                        ->get();
        }
        else $data = DB::table('users')
                            ->orderBy('id', 'ASC')
                                ->get(); 
      $total_row = $data->count();
      if($total_row > 0){
       foreach($data as $row){
        $output .= '
        <tr>
         <td>'.$row->id.'</td>
         <td>'.$row->username.'</td>
         <td>'.$row->email.'</td>
         <td>'.$row->role.'</td>
         <td>
         <a href="users/'.$row->id.'" class="btn btn-outline-light play_as">'.$prof.'</a>
         </td>
        </tr>
        ';
       }
      }
      else $output = '<tr> <td align="center" colspan="5">'.$NDF.'</td> </tr> ';
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }
}
