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

Route::group(['prefix'=>'admin/categories','middleware' => ['auth:' . UserGuard::GUARD_ADMIN]],function() {
   // Route::get('/', 'CategoryController@index');
    Route::get('/', ['as' => 'category-list', 'uses' => 'CategoryController@index']);
    Route::get('/create', ['as' => 'category-create', 'uses' => 'CategoryController@create']);
    Route::post('/store', ['as' => 'category-create', 'uses' => 'CategoryController@store']);
    Route::get('/edit/{id}', ['as' => 'category-edit', 'uses' => 'CategoryController@edit']);
    Route::get('/statusUpdate/{id}', ['as' => 'category-edit', 'uses' => 'CategoryController@statusUpdate']);
    Route::get('/featuredUpdate/{id}', ['as' => 'category-edit', 'uses' => 'CategoryController@featuredUpdate']);
    Route::post('/update/{id}', ['as' => 'category-edit', 'uses' => 'CategoryController@update']);
    Route::post('/destroy/{id}', ['as' => 'category-delete', 'uses' => 'CategoryController@destroy']);



    //////////////  Product Images
    Route::get('/subcats/{id}', ['as' => 'category-list', 'uses' => 'CategoryController@subCats']);
    Route::get('/subcats/create/{id}', ['as' => 'category-create', 'uses' => 'CategoryController@subcatCreate']);
    Route::post('/subcats/store/{id}', ['as' => 'category-create', 'uses' => 'CategoryController@subcatStore']);
    Route::get('/subcats/edit/{id}', ['as' => 'category-edit', 'uses' => 'CategoryController@subcatEdit']);
    Route::post('/subcats/update/{id}', ['as' => 'category-edit', 'uses' => 'CategoryController@subcatUpdate']);
    Route::post('/subcats/destroy/{id}', ['as' => 'category-delete', 'uses' => 'CategoryController@subcatDestroy']);
    Route::get('/subcats/statusUpdate/{id}', ['as' => 'category-edit', 'uses' => 'CategoryController@subcatStatusUpdate']);
    ///




});
