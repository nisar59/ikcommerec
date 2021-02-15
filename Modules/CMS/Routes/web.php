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

//Route::prefix('cms')->group(function() {
    Route::group(['prefix'=>'admin/cms','middleware' => ['auth:' . UserGuard::GUARD_ADMIN]],function() {
    Route::get('/', ['as' => 'cms-list', 'uses' => 'CMSController@index']);
    Route::get('/page', ['as' => 'page-list', 'uses' => 'CMSController@page_listing']);
    Route::post('/page_add' , 'CMSController@create_page');
    Route::get('/edit_page/{id}', 'CMSController@edit_page');
    Route::post('/update_page/{id}' , 'CMSController@update_page');
    Route::get('/delete_page/{id}' , 'CMSController@delete_page');
    Route::post('/sortabledatatable','CMSController@updateOrder');

    Route::get('/page/section/{id}' , 'CMSController@page_section_listing');
    Route::get('/section', 'CMSController@Section_listing');
    Route::post('/section_add' , 'CMSController@create_section');
    Route::post('/assign_section' , 'CMSController@assign_section');
    Route::get('/edit_section/{id}' , 'CMSController@edit_section');
    Route::post('/update_section/{id}' , 'CMSController@update_section');
    Route::get('/delete_section/{id}' , 'CMSController@delete_section');
    Route::get('/subsection/{id}', 'CMSController@Sub_Section_listing');
    Route::post('/subsection_add' , 'CMSController@create_sub_section');
    Route::get('/edit_subsection/{id}' , 'CMSController@edit_sub_section');
    Route::post('/update_subsection/{id}' , 'CMSController@update_sub_section');
    Route::get('/delete_subsection/{id}' , 'CMSController@delete_sub_section');

});
