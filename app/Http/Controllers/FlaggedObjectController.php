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
            $output = '';
            $showCharacters = NULL;
            $showUsers = NULL;
            $showGuilds = NULL;
            $query = $request->get('searchValue');
            // if($sortingParam != ''){
            //    if($sortingParam=='Level') $orderBy = 'level';
            //    if($sortingParam=='Strength') $orderBy = 'strength';
            //    if($sortingParam=='Duels') $orderBy = 'duelsWon';
            // }
            if($query != '') $data = DB::table('flagged_objects')->where('name', 'like', '%'.$query.'%')->orderBy('id', 'ASC')->get();
            else $data =  DB::table('flagged_objects')->orderBy('id', 'asc')->get(); 
            if($data->count() > 0){
            foreach($data as $row){
                $type = '';
                $address = '';
                if($row->user_id != NULL){
                    $address = 'users/'.$row->user_id;
                    $type = 'User';
                } 
                elseif($row->guild_id != NULL){
                    $address = $row->guild_id.'/guild';
                    $type = 'Guild';
                } 
                elseif($row->character_id != NULL){
                    $address = 'game/'.$row->character_id;
                    $type = 'Character';
                }
                $output .= '<tr>
                <td>'.$type.'</td>
                <td>'.$row->reason.'</td>
                <td>'.$row->created_at.'</td>
                <td><a href="'.$address.'" class="btn btn-outline-light play_as">View</a></td>
                <td><a href="/flagged/'.$row->id.'/delete" class="btn btn-outline-light play_as">Dismiss</a></td></tr>';
            }
        }
         else $output = '<tr> <td align="center" colspan="5">No Data Found</td> </tr> ';
         $data = array('table_data'  => $output);
         echo json_encode($data);
        }
    }
}
