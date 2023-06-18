<?php

namespace App\Http\Controllers;

use App\Models\Guild;
use App\Models\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $characters = Character::all();
        return view('characters', compact('characters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('character_new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $character = new Character();
        $character->name = $request->name;
        $character->user_id = $request->user_id;
        $character->level=1;
        $character->guild_id = NULL;
        $character->duelsWon = 0;
        $character->strength =0;
        $character->save();
        return redirect('profile');
    }

    /**
     * Display the specified resource.
     */
    public function show(){
        $characters = Character::where('user_id', '=', @auth()->user()->id)->first();
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
