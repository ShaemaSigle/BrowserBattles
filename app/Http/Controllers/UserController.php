<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Character;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // $users = User::all();
        return view('home');
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
    public function show()
    {
        $user = Auth::user();
        $characters = Character::where('user_id', '=', $user->id)->get();
        return view('profile', ['characters' => $characters]);
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
    public function update(Request $request)
    {
        $user = Auth::user();
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
}
