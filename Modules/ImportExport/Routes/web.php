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


    Route::group(['prefix'=>'admin/importexport','middleware' => ['auth:' . UserGuard::GUARD_ADMIN]],function() {
    Route::get('/', 'ImportExportController@create');
        Route::post('/save', 'ImportExportController@save');
});
