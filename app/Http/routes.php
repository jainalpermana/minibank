<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('dashboard');
});


Route::get('dashboard',['middleware'=>'periksaLogin', function () {
    return view('dashboard');
}]);

Route::get('pages', function () {
    return view('pages');
});
Route::post('nasabah/search','NasabahController@search');
Route::get('nasabah/contoh','NasabahController@contoh');
Route::post('nasabah/transaksi','NasabahController@transaksi');
Route::resource('nasabah','NasabahController');

Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::get('chek', 'NasabahController@status_login');
// laporan pdf
Route::get('laporan/pdf','LaporanController@pdf');
Route::get('laporan/excel','LaporanController@excel');