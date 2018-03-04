<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apprenant;
use App\Http\Resources\ApprenantResource;
use Image;

class ApprenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ApprenantResource::collection(Apprenant::all());
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
        // TESTS
        // $encoded_avatar = explode(",", $avatar_uri)[1];
        // $encoded_sign = explode(",", $sign_uri)[1];
        // $decoded_avatar = base64_decode($encoded_avatar);
        // $decoded_sign = base64_decode($encoded_sign);

        $first_name = $request['prenom'];
        $last_name = $request['nom'];
        $avatar_uri = $request['avatar'];
        $sign_uri = $request['sign'];

        $avatar_base64 = substr($avatar_uri, strpos($avatar_uri, ",")+1);
        $sign_base64 = substr($sign_uri, strpos($sign_uri, ",")+1);

        $time = time();

        $avatar_store_url = public_path().'/img/avatar/'.$first_name.'.'.$last_name.'.'.$time.'.png';
        $avatar_url = '/img/avatar/'.$first_name.'.'.$last_name.'.'.$time.'.png';
        Image::make($avatar_base64)->fit(100,100)->save($avatar_store_url);

        $sign_store_url = public_path().'/img/sign/'.$first_name.'.'.$last_name.'.'.$time.'.png';
        $sign_url = '/img/sign/'.$first_name.'.'.$last_name.'.'.$time.'.png';
        Image::make($sign_base64)->fit(400,200)->save($sign_store_url);
        
        Apprenant::create(['first_name' => $first_name, 'last_name' => $last_name, 'avatar' => $avatar_url, 'sign' => $sign_url]);
        
        return response()->json(['success'=> true, 'message'=> 'Thanks for signing up!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ApprenantResource(Apprenant::find($id));
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
        $apprenant = Apprenant::find($id);
        $apprenant->delete();
        
        return response()->json(['success' => true, 'message' => 'Apprenant supprimé !']);
    }
}
