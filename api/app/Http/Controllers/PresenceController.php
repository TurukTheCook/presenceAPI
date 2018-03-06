<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Presence;
use App\Http\Resources\PresenceResource;

class PresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PresenceResource::collection(Presence::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = $request['date'];
        $formation = $request['formation'];
        $lieu = $request['lieu'];

        $presence = Presence::where('date', '=', $date)->where('formation', '=', $formation)->where('lieu', '=', $lieu)->get();
        
        if(!$presence->isEmpty()){
            // return response()->json($presence[0]);
            return new PresenceResource(Presence::find($presence[0]->id));
        } else {
            $presence = Presence::create(['date' => $date, 'formation' => $formation, 'lieu' => $lieu]);
            // return response()->json($presence);
            return new PresenceResource(Presence::find($presence->id));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new PresenceResource(Presence::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $presence = Presence::find($id);
        $presence->delete();
        
        return response()->json(['success' => true, 'message' => 'Liste de présence supprimée !']);
    }
}
