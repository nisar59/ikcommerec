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

Route::group(['prefix'=>'admin/paymentsmethods','middleware' => ['auth:' . UserGuard::GUARD_ADMIN]],function() {

    Route::get('/', ['as' => 'paymentsmethods-list', 'uses' => 'PaymentsMethodsController@index']);
    Route::get('/create', ['as' => 'paymentsmethods-create', 'uses' => 'PaymentsMethodsController@create']);
    Route::post('/store', ['as' => 'paymentsmethods-create', 'uses' => 'PaymentsMethodsController@store']);
    Route::get('/edit/{id}', ['as' => 'paymentsmethods-edit', 'uses' => 'PaymentsMethodsController@edit']);
    Route::get('/statusUpdate/{id}', ['as' => 'paymentsmethods-edit', 'uses' => 'PaymentsMethodsController@statusUpdate']);
    Route::post('/update/{id}', ['as' => 'paymentsmethods-edit', 'uses' => 'PaymentsMethodsController@update']);
    Route::post('/destroy/{id}', ['as' => 'paymentsmethods-delete', 'uses' => 'PaymentsMethodsController@destroy']);
/////////////////  user roles




});