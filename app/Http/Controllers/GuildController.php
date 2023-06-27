<?php

namespace App\Http\Controllers;

use App\Models\Guild;
use App\Models\Character;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class GuildController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$guilds = Guild::all();
        //return view('guilds', compact('guilds'));
        return view('guilds');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Gate::allows('create-guild')) return view('guild_new');
        else return redirect('/guilds');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [ 'guild_name' => 'required', ]);
        if($validator->fails()) return redirect('/guilds/create')->withErrors($validator);
        $guild = new Guild();
        $guild->name = $request->guild_name;
        $guild->owner = $request->guild_owner;
        $guild->members_amount=1;
        $guild->icon_path = 'D:\Progs\Wamp.NET\sites\pract.assign.dev\resources\images\snek.jpg';
        $guild->description = $request->guild_description;
        $guild->isopen ='false';
        $owner = Character::where('id', '=', $request->guild_owner)->first();
        $guild->save();
        $owner->guild_id = $guild->id;
        $owner->save();
        return redirect($guild->id.'/guild');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $guild = Guild::where('id', '=', $id)->first();
        return view('guild', ['guild' => $guild]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
    
    public function join($id){ //it also manages leaving
        $guild = Guild::findOrFail($id);
        $character = Character::findOrFail(Auth::user()->active_character_id);
        if(Gate::allows('join-guild', $guild)){
            $character->guild_id = $id; 
            $guild->members_amount +=1;
            $guild->save();
        }
        $character->save();
        $guild->save();
        return redirect($id.'/guild');
    }

    public function leave($id){
        $guild = Guild::findOrFail($id);
        $character = Character::findOrFail(Auth::user()->active_character_id);
        if(Gate::allows('leave-guild', $guild)){
            $character->guild_id = NULL;
            $character->save();
            $guild->members_amount -=1;
        }
        $character->save();
        $guild->save();
        return redirect('guilds');
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
        $guild = Guild::findOrFail($id);
        if (Gate::allows('delete-guild', $guild)) {
            $characters = Character::Where('guild_id', '=', $id)->get();
            foreach($characters as $char){
                $char->guild_id = NULL;
                $char->save();
            }
            $guild->delete();
            return redirect("/guilds");
        } 
        else return redirect("/guilds")->withErrors('Access denied');
    }

    function list_members(Request $request, $id){
        $guild = Guild::where('id', '=', $id)->first();
        if($request->ajax()){
            $output = '';
            $query = $request->get('query');
            if($query != '') $data = DB::table('characters')->where('guild_id', 'like', $guild->id)->where('name', 'like', '%'.$query.'%')->get();
            else $data = DB::table('characters')->where('guild_id', 'like', $guild->id)->orderBy('level', 'desc')->get();
            $total_row = $data->count();
            $loc = Session::get("locale");
            if($loc == 'ru') $NDF = 'Информации не найдено.';
            elseif($loc == 'en') $NDF = 'No Data Found.';
            else $NDF = 'Informācija nav atrasta.';
            if($total_row > 0){
             foreach($data as $row){
              $output .= '
              <tr>
               <td>'.$row->name.'</td>
               <td>'.$row->strength.'</td>
               <td>'.$row->level.'</td>
               <td>'.$row->duelsWon.'</td>
              </tr>
              ';
             }
            }
            else{
             $output = '
             <tr> <td align="center" colspan="5">'.$NDF.'</td> </tr> ';
            }
            $data = array(
             'table_data'  => $output,
             'total_data'  => $total_row
            );
      
            echo json_encode($data);
        }
    }

    function action(Request $request){
     if($request->ajax()){
        //dd("sorting"); НЕ ЮЗАЙ ЭТУ ХУЙНЮ, В ПРОШЛЫЙ РАЗ ПОЛЧАСА ЕБАЛАСЬ, ЧТОБЫ ПОНЯТЬ, ПОЧЕМУ ВСЁ ВДРУГ СЛОМАЛОСЬ
        $query = $request->get('searchValue');
        $output = '';
        $orderByAD = '';
        $orderBy = '';
        $sortingParam = $request->get('sortValue');
        if($sortingParam != ''){
            if($sortingParam=='0'){
                $orderByAD = 'ASC';
                $orderBy = 'members_amount';
           } 
            if($sortingParam=='1'){
                $orderByAD= 'DESC';
                $orderBy = 'members_amount';
            }
            if($sortingParam=='2'){
                $orderByAD= 'ASC';
                $orderBy = 'name';
            }
        }
        if($query != '' && $sortingParam != ''){
            $data = DB::table('guilds')->where('name', 'like', '%'.$query.'%')->orderBy($orderBy, $orderByAD)->get();
             //  ->orWhere('Address', 'like', '%'.$query.'%')
           }
           else if($orderByAD != ''){
            $data = DB::table('guilds')->orderBy($orderBy, $orderByAD)->get();
           }
           else if($query != ''){
             $data = DB::table('guilds')->where('name', 'like', '%'.$query.'%')->get();
           }
           else $data =  DB::table('guilds')->orderBy('members_amount', 'asc')->get(); 
      $total_row = $data->count();
      $loc = Session::get("locale");
      if($loc == 'ru') {
        $NDF = 'Информации не найдено.';
        $closed = 'Закрытая';
        $open = 'Открытая';
      }
      elseif($loc == 'en'){
        $NDF = 'No Data Found.';
        $closed = 'Closed';
        $open = 'Open';
      } 
      else{
        $NDF = 'Informācija nav atrasta.';
        $closed = 'Slēgta';
        $open = 'Atvērta';
      } 
      if($total_row > 0){
       foreach($data as $row){
        if($row->isopen == 'false') $type = $closed;
        else $type = $open;
        $output .= '
        <tr>
         <td>'.$row->name.'</td>
         <td>'.$row->members_amount.'</td>
         <td>'.$row->description.'</td>
         <td>'.$type.'</td>
         <td>
         <a href="'.$row->id.'/guild'.'" class="btn btn-outline-light play_as">->👁️<-</a>
         </td>
        </tr>
        ';
       }
      }
      else $output = '<tr> <td align="center" colspan="5">'.$NDF.'</td> </tr> ';
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }
}
