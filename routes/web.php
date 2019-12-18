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

Route::get('/', function () {
    return view('layouts.home');
});

Route::resource('companies','CompanyController');
Route::resource('contracts','ContractController');
Route::resource('runs','OptimizerRunController');

Route::get('/optimize/feeds','OptimizerController@input_feeds');
Route::post('/optimize/feeds','OptimizerController@optimize_feeds');
