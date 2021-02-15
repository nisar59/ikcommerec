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



Route::group(['prefix'=>'admin/suppliers','middleware' => ['auth:' . UserGuard::GUARD_ADMIN]],function() {

    Route::get('/', ['as' => 'suppliers-list', 'uses' => 'SuppliersController@index']);
    Route::get('/create', ['as' => 'suppliers-create', 'uses' => 'SuppliersController@create']);
    Route::post('/store', ['as' => 'suppliers-create', 'uses' => 'SuppliersController@store']);
    Route::get('/edit/{id}', ['as' => 'suppliers-edit', 'uses' => 'SuppliersController@edit']);
    Route::get('/statusUpdate/{id}', ['as' => 'suppliers-edit', 'uses' => 'SuppliersController@statusUpdate']);
    Route::post('/update/{id}', ['as' => 'suppliers-edit', 'uses' => 'SuppliersController@update']);
    Route::post('/destroy/{id}', ['as' => 'suppliers-delete', 'uses' => 'SuppliersController@destroy']);
/////////////////  user roles




});
