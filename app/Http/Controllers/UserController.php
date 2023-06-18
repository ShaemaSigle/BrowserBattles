<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Character;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users', compact('users'));
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
        $user = User::findOrFail(Auth::user()->id);
        if($request->name != NULL) $user->username = $request->name;
        if($request->email != NULL) $user->email = $request->email;
        if($request->password != NULL) $user->password=$request->password;
        $user->active_character_id=$request->active_character_id;
        $user->save();
        return redirect('profile');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
