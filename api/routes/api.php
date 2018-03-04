<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('new_app', 'ApprenantController@store');
// Route::get('list_app_mod', 'ApprenantController@index');
// Route::get('app_mod', 'ApprenantController@show');

Route::apiResource('app_register', 'ApprenantController');