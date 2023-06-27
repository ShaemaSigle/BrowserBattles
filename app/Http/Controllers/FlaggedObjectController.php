<?php

namespace App\Http\Controllers;

use App\Models\Guild;
use App\Models\User;
use App\Models\Character;
use App\Models\FlaggedObject;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class FlaggedObjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('flagged');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return view('flag_new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $flag = new FlaggedObject();
        $object = NULL;
        if($request->guild_id != NULL) $flag->guild_id = $request->guild_id;
        if($request->character_id != NULL) $flag->character_id = $request->character_id;
        if($request->user_id != NULL) $flag->user_id = $request->user_id;
        $flag->reason = $request->reason;
        $flag->save();
        return redirect()->back();
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
    public function destroy(Request $request)
    {
        $flag = FlaggedObject::findOrFail($request->id);
        if(Gate::allows('delete-user')) $flag->delete();
        return redirect("/flagged");
    }

    function search(Request $request){
        if($request->ajax()){
            $loc = Session::get("locale");
            if($loc == 'ru') {
                $NDF = 'Информации не найдено.';
                $dismiss = 'Отклонить';
                $view = 'Взглянуть';
                $char = 'Персонаж';
                $guil = 'Гильдия';
                $usr = 'Пользователь';
            }
            elseif($loc == 'en'){
                $NDF = 'No Data Found.';
                $dismiss = 'Dismiss';
                $view = 'View';
                $char = 'Character';
                $guil = 'Guild';
                $usr = 'User';
            } 
            else{
                $NDF = 'Informācija nav atrasta.';
                $dismiss = 'Noraidīt';
                $view = 'Apskatīties';
                $char = 'Varonis';
                $guil = 'Gilde';
                $usr = 'Lietotājs';
            } 

            $output = '';
            $showCharacters = $request->get('showCharacters');
            $showUsers = $request->get('showUsers');
            $showGuilds = $request->get('showGuilds');
            if($showCharacters == 1) 
                $dataWithCharacter = DB::table('flagged_objects')->whereNotNull('character_id')->get();
            else $dataWithCharacter = DB::table('flagged_objects')->Where('character_id', 'like', '0')->get();
            if($showGuilds == 1)
                $dataWithGuild = DB::table('flagged_objects')->whereNotNull('guild_id')->get();
            else $dataWithGuild = DB::table('flagged_objects')->Where('guild_id', 'like', '0')->get();
            if($showUsers == 1)
                $dataWithUser = DB::table('flagged_objects')->whereNotNull('user_id')->get();
            else $dataWithUser = DB::table('flagged_objects')->Where('user_id', 'like', '0')->get();
            if($dataWithCharacter->count() > 0){
                foreach($dataWithCharacter as $row){
                    $address = 'game/'.$row->character_id;
                    $type = $char;
                    $output .= '<tr>
                    <td>'.$type.'</td>
                    <td>'.$row->reason.'</td>
                    <td>'.$row->created_at.'</td>
                    <td><a href="'.$address.'" class="btn btn-outline-light play_as">'.$view.'</a></td>
                    <td><a href="/flagged/'.$row->id.'/delete" class="btn btn-outline-light play_as">'.$dismiss.'</a></td></tr>';
                }
            }
            if($dataWithUser->count() > 0){
                foreach($dataWithUser as $row){
                    $address = 'users/'.$row->user_id;
                    $type = $usr;

                    $output .= '<tr>
                    <td>'.$type.'</td>
                    <td>'.$row->reason.'</td>
                    <td>'.$row->created_at.'</td>
                    <td><a href="'.$address.'" class="btn btn-outline-light play_as">'.$view.'</a></td>
                    <td><a href="/flagged/'.$row->id.'/delete" class="btn btn-outline-light play_as">'.$dismiss.'</a></td></tr>';
                }
            }
            if($dataWithGuild->count() > 0){
                foreach($dataWithGuild as $row){
                    $address = $row->guild_id.'/guild';
                    $type = $guil;
                    $output .= '<tr>
                    <td>'.$type.'</td>
                    <td>'.$row->reason.'</td>
                    <td>'.$row->created_at.'</td>
                    <td><a href="'.$address.'" class="btn btn-outline-light play_as">'.$view.'</a></td>
                    <td><a href="/flagged/'.$row->id.'/delete" class="btn btn-outline-light play_as">'.$dismiss.'</a></td></tr>';
                }
            }
            if($showCharacters == 0 && $showUsers == 0 && $showGuilds == 0) $output = '<tr> <td align="center" colspan="5">'.$NDF.'</td> </tr> ';
         $data = array('table_data'  => $output);
         echo json_encode($data);
        }
    }
}
