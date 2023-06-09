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
    public function duel($enemy_char_id)
    {
        if(Auth::user()->active_character_id == NULL) return redirect('game/0');
        $enemy = Character::findOrFail($enemy_char_id);
        return view('encounter', ['enemy' => $enemy]);
    }

    public function duel_won(Request $request)
    {
        if($request->ajax()){
            $winner = $request->get('winner');
            if($winner == 'player'){
                $character = Character::findOrFail(Auth::user()->active_character_id); 
                $character->duelsWon = $character->duelsWon + 1;
                $character->save();
            }            
        }
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
        $encounter->enemy_id = rand(1, 5);
        $encounter->save();
        return view('encounter', compact('encounter'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $encounter = Encounter::findOrFail($id);
        $character = Character::findOrFail(Auth::user()->active_character_id);
        //If the targeted encounter already has a result, it should not be loaded
        if($encounter->result == NULL && $character->id == $encounter->character_id) return view('encounter', ['encounter' => $encounter]);
        else return redirect('game');
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
        $character = Character::findOrFail(Auth::user()->active_character_id);
        if($request->ajax()){
            $newLVL = 'false';
            $encounter = Encounter::findOrFail($request->get('encounter'));
            $winner = $request->get('winner');
            if($winner == 'player'){
                $encounter->result = "userWon";
                $enemy = Enemy::findOrFail($encounter->enemy_id);
                $character->strength = $character->strength + $enemy->strength;
                if($character->strength / $character->level >= 1000){
                    $character->level += 1;
                    $newLVL = 'true';
                }
                $character->save();
            }
            elseif($winner == 'enemy'){
                $encounter->result = "userLost";
            }
            $encounter->save();
            return response()->json(['ok' => 'ok', 'newLVL' => $newLVL]);
        }
        elseif($request->result == "userLost") {
            $encounter = Encounter::findOrFail($request->encounter);
            $encounter->result = "userLost";
        }
        $encounter->save();
        //return view('encounter', ['encounter' => $encounter]);
        return redirect('game/'.$character->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
