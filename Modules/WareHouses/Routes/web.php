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


Route::group(['prefix'=>'admin/warehouses','middleware' => ['auth:' . UserGuard::GUARD_ADMIN]],function() {

    Route::get('/', ['as' => 'warehouses-list', 'uses' => 'WareHousesController@index']);
    Route::get('/create', ['as' => 'warehouses-create', 'uses' => 'WareHousesController@create']);
    Route::post('/store', ['as' => 'warehouses-create', 'uses' => 'WareHousesController@store']);
    Route::get('/edit/{id}', ['as' => 'warehouses-edit', 'uses' => 'WareHousesController@edit']);
    Route::get('/statusUpdate/{id}', ['as' => 'warehouses-edit', 'uses' => 'WareHousesController@statusUpdate']);
    Route::post('/update/{id}', ['as' => 'warehouses-edit', 'uses' => 'WareHousesController@update']);
    Route::post('/destroy/{id}', ['as' => 'warehouses-delete', 'uses' => 'WareHousesController@destroy']);
/////////////////  user roles




});
