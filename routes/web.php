<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', 'CardWiki@index');
Route::post('card', 'CardWiki@showCard');
Route::get('/fow', 'CardWiki@testForceOfWill');
Route::get('/report', 'Report@index');

Route::get('/testDatabase', 'CardWiki@testDatabase');
