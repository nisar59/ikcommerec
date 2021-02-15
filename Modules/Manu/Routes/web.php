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

Route::group(['prefix'=>'admin/menu','middleware' => ['auth:' . UserGuard::GUARD_ADMIN]],function() {
    // Route::get('/', 'CategoryController@index');
    Route::get('/', ['as' => 'menu-list', 'uses' => 'ManuController@index']);
    Route::get('/create', ['as' => 'menu-create', 'uses' => 'ManuController@create']);
    Route::post('/store', ['as' => 'menu-create', 'uses' => 'ManuController@store']);
    Route::get('/edit/{id}', ['as' => 'menu-edit', 'uses' => 'ManuController@edit']);
    Route::get('/statusUpdate/{id}', ['as' => 'menu-edit', 'uses' => 'ManuController@statusUpdate']);
    Route::post('/update/{id}', ['as' => 'menu-edit', 'uses' => 'ManuController@update']);
    Route::post('/destroy/{id}', ['as' => 'menu-delete', 'uses' => 'ManuController@destroy']);

    //////////////

    Route::get('/items/{id}', ['as' => 'menu-list', 'uses' => 'ManuController@itemsIndex']);
    Route::get('/items/create/{id}', ['as' => 'menu-create', 'uses' => 'ManuController@itemsCreate']);

    Route::post('/items/store/{id}', ['as' => 'menu-create', 'uses' => 'ManuController@itemsStore']);
    Route::get('/items/edit/{id}', ['as' => 'menu-edit', 'uses' => 'ManuController@itemsEdit']);
    Route::get('/items/statusUpdate/{id}', ['as' => 'menu-edit', 'uses' => 'ManuController@itemsStatusUpdate']);
    Route::post('/items/update/{id}', ['as' => 'menu-edit', 'uses' => 'ManuController@itemsUpdate']);
    Route::post('/items/destroy/{id}', ['as' => 'menu-delete', 'uses' => 'ManuController@itemsDestroy']);
    ///


});
