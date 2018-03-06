<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IndividualPresence;
use App\Http\Resources\IndividualPresenceResource;

class IndividualPresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return IndividualPresenceResource::collection(IndividualPresence::all());
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
        $presence_id = $request['presence_id'];
        $presence_apprenants = $request['apprenants'];

        $presence_list = IndividualPresence::where('presence_id', '=', $presence_id)->get();
        
        if(!$presence_list->isEmpty()){
            return IndividualPresenceResource::collection($presence_list);
        } else {
            for($i = 0; $i < count($presence_apprenants); $i++){
                    IndividualPresence::create(['presence_id' => $presence_id, 'apprenant_id' => $presence_apprenants[$i]]);
                }
                $new_presence_list = IndividualPresence::where('presence_id', '=', $presence_id)->get();
                return IndividualPresenceResource::collection($new_presence_list);
            }
            // return response()->json(['test' => $presence_id, 'test2' => $presence_apprenants, 'test3' => $presence_list]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new IndividualPresenceResource(IndividualPresence::find($id));
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
        $presence_id = $request['presence_id'];
        $apprenant_presence_collection = IndividualPresence::where('apprenant_id', '=', $id)->where('presence_id', '=', $presence_id)->get();
        $apprenant_presence = IndividualPresence::find($apprenant_presence_collection[0]->id);
        
        $type = $request['type'];
        $absent = $request['absent'];

        if($type == 'matin') {
            $apprenant_presence->absent_matin = $absent;
            $apprenant_presence->save();
            return response()->json(['success' => true, 'message' => 'Présence du matin mise à jour !']);
        }
        else {
            $apprenant_presence->absent_aprem = $absent;
            $apprenant_presence->save();
            return response()->json(['success' => true, 'message' => "Présence de l'aprem mise à jour !"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
