<?php

namespace App\Http\Controllers;

use App\Models\Guild;
use App\Models\User;
use App\Models\Character;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $user = Auth::user();
        $character = Character::findOrFail($id);
        if($user->active_character_id==$id) $user->active_character_id = NULL;
        $character->delete();
        $user->save();
        return redirect("/profile");
    }

    function live(Request $request){
        $user = Auth::user();
        if($user != NULL && $user->active_character_id != NULL)$mychar = $user->active_character_id;
        if($request->ajax()){
           $output = '';
           $orderByAD = 'DESC';
           $orderBy = '';
           $sortingParam = $request->get('sortValue');
           if($sortingParam != ''){
               if($sortingParam=='Level')
                   $orderBy = 'level';
               if($sortingParam=='Strength') 
                   $orderBy = 'strength';
               if($sortingParam=='Duels') 
                   $orderBy = 'duelsWon';
           }
           if($sortingParam != '') $data = DB::table('characters')->orderBy($orderBy, $orderByAD)->get();
           else $data =  DB::table('characters')->orderBy('level', 'desc')->get(); 
         if($data->count() > 0){
            $counter=1;
            $finpos = 0;
          foreach($data as $row){
            if($mychar && $row->id != $mychar) $counter +=1;
            //else $finpos = $counter;
           $output .= '
           <tr>
           <td>'.$row->name.'</td>
           <td>'.$row->guild_id.'</td>
           <td>'.$row->strength.'</td>
           <td>'.$row->level.'</td>
           <td>'.$row->duelsWon.'</td>
            <td>
            <a href="#" class="btn btn-outline-light play_as">Press here to duel</a>
            </td></tr>';
         }
        }
         else $output = '<tr> <td align="center" colspan="5">No Data Found</td> </tr> ';
         $data = array(
          'table_data'  => $output,
          'pos' => $finpos
         );

         echo json_encode($data);
        }
    }
}
