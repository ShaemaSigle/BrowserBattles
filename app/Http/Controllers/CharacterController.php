<?php

namespace App\Http\Controllers;

use App\Models\Guild;
use App\Models\User;
use App\Models\Character;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use SebastianBergmann\LinesOfCode\Counter;

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
        $validator = Validator::make($request->all(), [ 'name' => 'required', ]);
        if($validator->fails()) return redirect('/characters/create')->withErrors($validator);
        $character = new Character();
        $character->name = $request->name;
        $character->user_id = $request->user_id;
        $character->level=1;
        $character->guild_id = NULL;
        $character->duelsWon = 0;
        $character->strength = 150;
        $character->save();
        return redirect('profile');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request){
        //dd('yup');
        if($request->id == 0)  return view('game');
        $character = Character::findOrFail($request->id);
        //dd($character->name);
        if(Gate::allows('view-character', $character)) return view('game', ['character' => $character]);
        elseif(Auth::user()->active_character_id != NULL)return redirect('game/'.Auth::user()->active_character_id);
        else return redirect('game/0');
        //else return view('game', ['character' => Character::findOrFail(Auth::user()->active_character_id)]);
        // $characters = Character::where('user_id', '=', @auth()->user()->id)->first();
        // return view('profile', ['characters' => $characters]);
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
        $user = Auth::user();
        $character = Character::findOrFail($id);
        if($user->active_character_id==$id) $user->active_character_id = NULL;
        $character->delete();
        $user->save();
        return redirect("/profile");
    }

    function live(Request $request){
        $user = Auth::user();
        $mychar = NULL;
        if($user != NULL && $user->active_character_id != NULL)$mychar = $user->active_character_id;
        $loc = Session::get("locale");
        if($loc == 'ru') {
            $NDF = 'Информации не найдено.';
            $duel = 'Вызвать на дуэль';
        }
        elseif($loc == 'en'){
            $NDF = 'No Data Found.';
            $duel = 'Ask for a duel';
        } 
        else{
            $NDF = 'Informācija nav atrasta.';
            $duel = 'Izaicināt uz dueli';
        } 
        if($request->ajax()){
            $output = '';
            $orderByAD = 'DESC';
            $orderBy = '';
            $sortingParam = $request->get('sortValue');
            if($sortingParam != ''){
               if($sortingParam=='0') $orderBy = 'level';
               if($sortingParam=='1') $orderBy = 'strength';
               if($sortingParam=='2') $orderBy = 'duelsWon';
            }
            if($sortingParam != '') 
                $data = DB::table('characters')
                    ->join('guilds', 'characters.guild_id', '=', 'guilds.id')
                        ->select('characters.name as character_name', 'characters.id as id', 'guilds.name as guild_name', 'characters.strength', 'characters.level', 'characters.duelsWon')
                            ->orderBy($orderBy, $orderByAD)
                                ->get();
            else $data =  DB::table('characters')
                ->join('guilds', 'characters.guild_id', '=', 'guilds.id')
                    ->select('characters.name as character_name', 'characters.id as id', 'guilds.name as guild_name', 'characters.strength', 'characters.level', 'characters.duelsWon')
                        ->orderBy('level', 'desc')
                            ->get(); 

            if($data->count() > 0){
                $counter=1;
                $finpos = 0;
            foreach($data as $row){
                $output .= '<tr>
                <td>'.$counter.'</td>
                <td>'.$row->character_name.'</td>
                <td>'.$row->guild_name.'</td>
                <td>'.$row->strength.'</td>
                <td>'.$row->level.'</td>
                <td>'.$row->duelsWon.'</td>
                <td><a href="/game/duel/'.$row->id.'" class="btn btn-outline-light play_as">'.$duel.'</a></td></tr>';
                if($mychar != NULL && $row->id == $mychar) $finpos = $counter;
                $counter +=1;
            }
        }
         else $output = '<tr> <td align="center" colspan="5">'.$NDF.'</td> </tr> ';
         $data = array('table_data'  => $output, 'pos' => $finpos);
         echo json_encode($data);
        }
    }
}
