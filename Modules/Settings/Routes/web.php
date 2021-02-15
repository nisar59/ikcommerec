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


Route::group(['prefix'=>'admin/settings','middleware' => ['auth:' . UserGuard::GUARD_ADMIN]],function() {

    Route::get('/', ['as' => 'settings-list', 'uses' => 'SettingsController@index']);
   // Route::get('/create', ['as' => 'settings-create', 'uses' => 'SettingsController@create']);
  //  Route::post('/store', ['as' => 'settings-create', 'uses' => 'SettingsController@store']);
   // Route::get('/edit/{id}', ['as' => 'settings-edit', 'uses' => 'SettingsController@edit']);
   // Route::get('/statusUpdate/{id}', ['as' => 'settings-edit', 'uses' => 'SettingsController@statusUpdate']);
    Route::post('/update', ['as' => 'settings-edit', 'uses' => 'SettingsController@update']);
    Route::post('/destroy/{id}', ['as' => 'settings-delete', 'uses' => 'SettingsController@destroy']);
/////////////////  user roles
});