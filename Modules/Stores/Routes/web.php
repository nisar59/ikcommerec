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


Route::group(['prefix'=>'admin/stores','middleware' => ['auth:' . UserGuard::GUARD_ADMIN]],function() {

    Route::get('/', ['as' => 'stores-list', 'uses' => 'StoresController@index']);
    Route::get('/create', ['as' => 'stores-create', 'uses' => 'StoresController@create']);
    Route::post('/store', ['as' => 'stores-create', 'uses' => 'StoresController@store']);
    Route::get('/edit/{id}', ['as' => 'stores-edit', 'uses' => 'StoresController@edit']);
    Route::get('/statusUpdate/{id}', ['as' => 'stores-edit', 'uses' => 'StoresController@statusUpdate']);
    Route::post('/update/{id}', ['as' => 'stores-edit', 'uses' => 'StoresController@update']);
    Route::post('/destroy/{id}', ['as' => 'stores-delete', 'uses' => 'StoresController@destroy']);
/////////////////  user roles




});