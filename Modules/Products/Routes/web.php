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


Route::group(['prefix'=>'admin/products','middleware' => ['auth:' . UserGuard::GUARD_ADMIN]],function() {
    // Route::get('/', 'CategoryController@index');
    Route::get('/', ['as' => 'products-list', 'uses' => 'ProductsController@index']);
    Route::get('/create', ['as' => 'products-create', 'uses' => 'ProductsController@create']);
    Route::post('/store', ['as' => 'products-create', 'uses' => 'ProductsController@store']);
    Route::get('/edit/{id}', ['as' => 'products-edit', 'uses' => 'ProductsController@edit']);
    Route::get('/statusUpdate/{id}', ['as' => 'products-edit', 'uses' => 'ProductsController@statusUpdate']);
   
    
    Route::get('/featuredUpdate/{id}', ['as' => 'products-edit', 'uses' => 'ProductsController@featuredUpdate']);
    Route::get('/stocksUpdate/{id}', ['as' => 'products-edit', 'uses' => 'ProductsController@stocksUpdate']);
    Route::get('/reviewsUpdate/{id}', ['as' => 'products-edit', 'uses' => 'ProductsController@reviewsUpdate']);




    Route::post('/update/{id}', ['as' => 'products-edit', 'uses' => 'ProductsController@update']);
    Route::post('/destroy/{id}', ['as' => 'products-delete', 'uses' => 'ProductsController@destroy']);





    //////////////  Product Images
    Route::get('/images/{id}', ['as' => 'products-list', 'uses' => 'ProductsController@images']);
    Route::get('/images/create/{id}', ['as' => 'products-create', 'uses' => 'ProductsController@imageCreate']);
    Route::post('/images/store/{id}', ['as' => 'products-create', 'uses' => 'ProductsController@imageStore']);
    Route::get('/images/edit/{id}', ['as' => 'products-edit', 'uses' => 'ProductsController@imageEdit']);
    Route::post('/images/update/{id}', ['as' => 'products-edit', 'uses' => 'ProductsController@imageUpdate']);
    Route::post('/images/destroy/{id}', ['as' => 'products-delete', 'uses' => 'ProductsController@imageDestroy']);
    ///
    ///
    Route::get('/stores/{id}', ['as' => 'products-list', 'uses' => 'ProductsController@stores']);
    Route::post('assign/store/{id}', ['as' => 'products-create', 'uses' => 'ProductsController@assignStore']);
    Route::get('/unassigned/{id}', ['as' => 'products-list', 'uses' => 'ProductsController@unassignedstores']);

    Route::get('/reviews/{id}', ['as' => 'products-list', 'uses' => 'ProductsController@reviews']);
    Route::post('/review/destroy/{id}', ['as' => 'products-delete', 'uses' => 'ProductsController@reviewdestroy']);
    Route::get('/ReviewstatusUpdate/{id}', ['as' => 'products-edit', 'uses' => 'ProductsController@ReviewstatusUpdate']);

    ///

});
