<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Encounter;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class EncounterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('game');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$character = Character::findOrFail(Auth::user()->active_character_id);
        $encounter = new Encounter();
        $encounter->character_id = $request->active_character_id;
        $encounter->enemy_id = rand(1, 3);
        $encounter->save();
        return redirect('game/encounter/'.$encounter->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $encounter = Encounter::findOrFail($id);
        if($encounter->result != NULL) return view('game');
        else return view('encounter', ['encounter' => $encounter]);
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
