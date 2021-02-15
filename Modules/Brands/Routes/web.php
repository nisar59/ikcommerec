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


Route::group(['prefix'=>'admin/brands','middleware' => ['auth:' . UserGuard::GUARD_ADMIN]],function() {

    Route::get('/', ['as' => 'brands-list', 'uses' => 'BrandsController@index']);
    Route::get('/create', ['as' => 'brands-create', 'uses' => 'BrandsController@create']);
    Route::post('/store', ['as' => 'brands-create', 'uses' => 'BrandsController@store']);
    Route::get('/edit/{id}', ['as' => 'brands-edit', 'uses' => 'BrandsController@edit']);
    Route::get('/statusUpdate/{id}', ['as' => 'brands-edit', 'uses' => 'BrandsController@statusUpdate']);
    Route::post('/update/{id}', ['as' => 'brands-edit', 'uses' => 'BrandsController@update']);
    Route::post('/destroy/{id}', ['as' => 'brands-delete', 'uses' => 'BrandsController@destroy']);
/////////////////  user roles




});
