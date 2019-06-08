<?php

use Illuminate\Http\Request;
use App\Models\Corredor;

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

Route::get('/', function () {

    return response()->json('API-RACER-OK. V 1.0', 200);
});

Route::post('/corredores', 'CorredorController@store');
Route::post('/provas', 'ProvaController@store');
Route::post('/corredoresProvas', 'ProvaController@storeCorredorProva');