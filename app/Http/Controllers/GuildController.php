<?php

namespace App\Http\Controllers;

use App\Models\Guild;
use App\Models\Character;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

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
    public function destroy(string $guild)
    {
       // if (Gate::denies('is-admin')) {  return redirect('dashboard') ->withErrors('Access denied');}
            
        $guild = Guild::findOrFail($guild);
        $guild->delete();
        return redirect("/guilds");
    }

    function action(Request $request)
    {
     if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != ''){
       $data = DB::table('guilds')
         ->where('name', 'like', '%'.$query.'%')->get();
        //  ->orWhere('Address', 'like', '%'.$query.'%')
        //  ->orWhere('City', 'like', '%'.$query.'%')
        //  ->orWhere('PostalCode', 'like', '%'.$query.'%')
        //  ->orWhere('Country', 'like', '%'.$query.'%')
        //  ->orderBy('CustomerID', 'desc')
      }
      else{
       $data = DB::table('guilds')->orderBy('id', 'desc')->get();
      }
      $total_row = $data->count();
      if($total_row > 0){
       foreach($data as $row){
        $html = $row->id.'/guild';
        $output .= '
        <tr>
         <td>'.$row->name.'</td>
         <td>'.$row->members_amount.'</td>
         <td>'.$row->description.'</td>
         <td>'.$row->isopen.'</td>
         <td>
         <a href="'.$html.'" class="btn btn-outline-light play_as">Press here to view</a>
         </td>
        </tr>
        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }

}
