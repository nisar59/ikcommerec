<?php
use App\UserGuard;
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

Route::group(['prefix'=>'admin/variations','middleware' => ['auth:' . UserGuard::GUARD_ADMIN]],function() {
    Route::get('/', 'VariationsController@index');
    Route::get('/create', 'VariationsController@create');
    Route::post('/store', 'VariationsController@store');
    Route::get('/edit/{id}', 'VariationsController@edit');
    Route::post('/update/{id}', 'VariationsController@update');
 	Route::post('/destroy/{id}','VariationsController@destroy');
});

Route::group(['prefix'=>'admin/variations/values','middleware' => ['auth:' . UserGuard::GUARD_ADMIN]],function() {
    Route::get('/{id}', 'VariationValuesController@index');
    Route::get('/create/{id}', 'VariationValuesController@create');
    Route::post('/store', 'VariationValuesController@store');
    Route::get('/edit/{id}', 'VariationValuesController@edit');
    Route::post('/update/{id}', 'VariationValuesController@update');
 	Route::post('/destroy/{id}','VariationValuesController@destroy');
});
