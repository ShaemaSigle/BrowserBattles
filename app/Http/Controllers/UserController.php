<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Character;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $characters = Character::where('user_id', '=', $user->id)->get();
        return view('profile', ['characters' => $characters, 'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $userID = '')
    {
        if($userID=='')$user = Auth::user(); //check with middleware later
        else $user = User::findOrFail($userID);
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
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('\assets\img'), $request->image->getClientOriginalName());
                $user->profpic_path=$request->image->getClientOriginalName();
            }
            else return redirect('profile')->withErrors($validator);
        } 
        if($request->active_character_id != NULL) $user->active_character_id=$request->active_character_id;
        $user->save();
        return redirect('profile');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        app('App\Http\Controllers\LogoutController')->perform();
        User::findOrfail($id)->delete();
        return redirect("/");
    }

    function search(Request $request){
    if($request->ajax()){
        //dd("sorting"); НЕ ЮЗАЙ ЭТУ ХУЙНЮ, В ПРОШЛЫЙ РАЗ ПОЛЧАСА ЕБАЛАСЬ, ЧТОБЫ ПОНЯТЬ, ПОЧЕМУ ВСЁ ВДРУГ СЛОМАЛОСЬ
        $query = $request->get('searchValue');
        $output = '';
        $orderByAD = '';
        $orderBy = '';
        $sortingParam = ''; //$request->get('sortValue');
        if($sortingParam != ''){
            if($sortingParam=='MembersAsc'){
                $orderByAD = 'ASC';
                $orderBy = 'members_amount';
           } 
            if($sortingParam=='MembersDesc'){
                $orderByAD= 'DESC';
                $orderBy = 'members_amount';
            }
            if($sortingParam=='Alfabetically'){
                $orderByAD= 'ASC';
                $orderBy = 'name';
            }
        }
        if($query != ''){
            $data = DB::table('users')->where('username', 'like', '%'.$query.'%')->orderBy('id', 'ASC')->get();
        }
        else $data =  DB::table('users')->orderBy('id', 'ASC')->get(); 

        // if($query != '' && $sortingParam != ''){
        //     $data = DB::table('users')->where('username', 'like', '%'.$query.'%')->orderBy($orderBy, $orderByAD)->get();
        //      //  ->orWhere('Address', 'like', '%'.$query.'%')
        //    }
        //    else if($orderByAD != ''){
        //     $data = DB::table('guilds')->orderBy($orderBy, $orderByAD)->get();
        //    }
        //    else if($query != ''){
        //      $data = DB::table('guilds')->where('name', 'like', '%'.$query.'%')->get();
        //    }
        //    else $data =  DB::table('guilds')->orderBy('id', 'desc')->get(); 
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
         <a href="'.$row->id.'/guild'.'" class="btn btn-outline-light play_as">Press here to view</a>
         </td>
         <td>
         <a href="'.$row->id.'/guild'.'" class="btn btn-outline-light play_as">DELETE</a>
         </td>
        </tr>
        ';
       }
      }
      else $output = '<tr> <td align="center" colspan="5">No Data Found</td> </tr> ';
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }
}
