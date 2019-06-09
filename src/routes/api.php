<?php
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
Route::post('/corredores/provas/inscricao', 'ProvaController@storeCorredorProva');
Route::post('/provas/resultados', 'ProvaController@resultados');
Route::get('provas/classificacoes/idade/{tipo_prova?}', 'ProvaController@listaPorIdade');
Route::get('provas/classificacoes/geral', 'ProvaController@listaGeral');