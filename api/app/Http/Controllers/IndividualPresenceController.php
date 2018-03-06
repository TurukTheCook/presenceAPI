<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IndividualPresence;
use App\Http\Resources\IndividualPresenceResource;
use Image;

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
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];

        $sign_uri = $request['sign'];

        $time = time();

        if($type == 'matin') {
            if ($sign_uri != null){
                $sign_base64 = substr($sign_uri, strpos($sign_uri, ",")+1);
                $sign_store_url = public_path().'/img/sign/presence/'.$first_name.'.'.$last_name.'.matin.'.$time.'.png';
                $sign_matin_url = '/img/sign/presence/'.$first_name.'.'.$last_name.'.matin.'.$time.'.png';
                Image::make($sign_base64)->fit(200,100)->save($sign_store_url);
            } else {
                $sign_matin_url = $apprenant_presence->sign_matin;
            }
            $apprenant_presence->sign_matin = $sign_matin_url;
            $apprenant_presence->absent_matin = $absent;
            $apprenant_presence->save();
            return new IndividualPresenceResource(IndividualPresence::find($apprenant_presence->id));
        }
        else {
            if ($sign_uri != null){
                $sign_base64 = substr($sign_uri, strpos($sign_uri, ",")+1);
                $sign_store_url = public_path().'/img/sign/presence/'.$first_name.'.'.$last_name.'.aprem.'.$time.'.png';
                $sign_aprem_url = '/img/sign/presence/'.$first_name.'.'.$last_name.'.aprem.'.$time.'.png';
                Image::make($sign_base64)->fit(200,100)->save($sign_store_url);
            } else {
                $sign_aprem_url = $apprenant_presence->sign_aprem;
            }
            $apprenant_presence->sign_aprem = $sign_aprem_url;
            $apprenant_presence->absent_aprem = $absent;
            $apprenant_presence->save();
            return new IndividualPresenceResource(IndividualPresence::find($apprenant_presence->id));
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
