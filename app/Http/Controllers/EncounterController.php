<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Encounter;
use App\Models\Enemy;
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
        //It is possible that the user has an unfinished battle with no result, 
        //in which case it has to be finished before creating a new encounter.

        $encounter = Encounter::Where('character_id', '=', $request->active_character_id)->where('result', '=', NULL)->first();
        if($encounter != NULL) return view('encounter', compact('encounter'));
        $encounter = new Encounter();
        $encounter->character_id = $request->active_character_id;
        $encounter->enemy_id = rand(1, 3);
        $encounter->save();
        return view('encounter', compact('encounter'));
        //return redirect('game/encounter/'.$encounter->id)->with([ 'encounter' => $encounter ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $encounter = Encounter::findOrFail($id);
        //If the targeted encounter already has a result, it should not be loaded
        if($encounter->result != NULL) return redirect('game');
        else return view('encounter', ['encounter' => $encounter]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $encounter = Encounter::findOrFail($request->encounter);
        if($request->result == "userLost") {
            $encounter->result = "userLost";
            $encounter->save();
        }
        if($encounter->result == NULL){
            $character = Character::findOrFail($request->active_character_id);
            $enemy_strength = (Enemy::findOrFail($encounter->enemy_id))->strength;
            if($character->strength < $enemy_strength) $encounter->result = "userLost";
            else{
                $encounter->result = "userWon";
                $character->strength = $character->strength + $enemy_strength;
                if($character->strength / $character->level >= 1000) $character->level += 1;
                $character->save();
            } 
            $encounter->save();
        }
        return view('encounter', ['encounter' => $encounter]);
        //return redirect('game');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
