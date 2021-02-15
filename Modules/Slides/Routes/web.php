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


Route::group(['prefix'=>'admin/slides','middleware' => ['auth:' . UserGuard::GUARD_ADMIN]],function() {

    Route::get('/', ['as' => 'slides-list', 'uses' => 'SlidesController@index']);
    Route::get('/create', ['as' => 'slides-create', 'uses' => 'SlidesController@create']);
    Route::post('/store', ['as' => 'slides-create', 'uses' => 'SlidesController@store']);
    Route::get('/edit/{id}', ['as' => 'slides-edit', 'uses' => 'SlidesController@edit']);
    Route::get('/statusUpdate/{id}', ['as' => 'slides-edit', 'uses' => 'SlidesController@statusUpdate']);
    Route::post('/update/{id}', ['as' => 'slides-edit', 'uses' => 'SlidesController@update']);
    Route::post('/destroy/{id}', ['as' => 'slides-delete', 'uses' => 'SlidesController@destroy']);
/////////////////  user roles




});
