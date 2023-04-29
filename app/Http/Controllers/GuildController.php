<?php

namespace App\Http\Controllers;

use App\Models\Guild;
use App\Models\Character;
use Illuminate\Http\Request;

class GuildController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guilds = Guild::all();
        return view('guilds', compact('guilds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('guild_new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $guild = new Guild();
        $guild->name = $request->guild_name;
        $guild->owner = $request->guild_owner;
        $guild->members_amount=1;
        $guild->icon_path = 'D:\Progs\Wamp.NET\sites\pract.assign.dev\resources\images\snek.jpg';
        $guild->description = '';
        $guild->isopen ='false';
        $guild->save();
        return redirect('4/guild');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $guild = Guild::where('id', '=', $id)->first();
        $characters = Character::where('guild_id', '=', $id)->get();
        return view('guild', ['guild' => $guild, 'characters' => $characters]);
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
