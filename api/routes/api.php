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

// INSCRIPTION LIST
Route::apiResource('app_register', 'ApprenantController');

// PRESENCE LIST ROUTES
Route::apiResource('presence_list', 'PresenceController');

// INDIVIDUAL PRESENCE ROUTES
Route::apiResource('individual_presence', 'IndividualPresenceController');