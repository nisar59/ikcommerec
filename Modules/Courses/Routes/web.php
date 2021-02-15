<?php

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

Route::group(['prefix'=>'courses','middleware' => ['auth']],function() {
    // Route::get('/', 'CategoryController@index');
    Route::get('/', ['as' => 'course-list', 'uses' => 'CoursesController@index']);
    Route::get('/create', ['as' => 'course-create', 'uses' => 'CoursesController@create']);
    Route::post('/store', ['as' => 'course-create', 'uses' => 'CoursesController@store']);
    Route::get('/edit/{id}', ['as' => 'course-edit', 'uses' => 'CoursesController@edit']);
    Route::get('/statusUpdate/{id}', ['as' => 'course-edit', 'uses' => 'CoursesController@statusUpdate']);
    Route::post('/update/{id}', ['as' => 'course-edit', 'uses' => 'CoursesController@update']);
    Route::post('/destroy/{id}', ['as' => 'course-delete', 'uses' => 'CoursesController@destroy']);

    /////////////  course faq routes
    Route::get('/faqs/{id}', ['as' => 'course-list', 'uses' => 'CoursesController@faqs']);
    Route::get('/faqs/create/{id}', ['as' => 'course-create', 'uses' => 'CoursesController@faqsCreate']);
    Route::post('/faqs/store', ['as' => 'course-create', 'uses' => 'CoursesController@faqsStore']);
    Route::get('/faqs/edit/{id}', ['as' => 'course-edit', 'uses' => 'CoursesController@faqsEdit']);
    Route::get('/faqs/statusUpdate/{id}', ['as' => 'course-edit', 'uses' => 'CoursesController@faqsStatusUpdate']);
    Route::post('/faqs/update/{id}', ['as' => 'course-edit', 'uses' => 'CoursesController@faqsUpdate']);
    Route::post('/faqs/destroy/{id}', ['as' => 'course-delete', 'uses' => 'CoursesController@faqsDestroy']);
    ///
    /////////////  course Librarires routes
    Route::get('/libraries/{id}', ['as' => 'course-list', 'uses' => 'CoursesController@libraries']);
    Route::get('/libraries/create/{id}', ['as' => 'course-create', 'uses' => 'CoursesController@librariesCreate']);
    Route::post('/libraries/store', ['as' => 'course-create', 'uses' => 'CoursesController@librariesStore']);
    Route::get('/libraries/edit/{id}', ['as' => 'course-edit', 'uses' => 'CoursesController@librariesEdit']);
    Route::get('/libraries/statusUpdate/{id}', ['as' => 'course-edit', 'uses' => 'CoursesController@librariesStatusUpdate']);
    Route::post('/libraries/update/{id}', ['as' => 'course-edit', 'uses' => 'CoursesController@librariesUpdate']);
    Route::post('/libraries/destroy/{id}', ['as' => 'course-delete', 'uses' => 'CoursesController@librariesDestroy']);
    ///
    ///
    /////////////  course Announcemnts routes
    Route::get('/announcemnts/{id}', ['as' => 'course-list', 'uses' => 'CoursesController@announcemnts']);
    Route::get('/announcemnts/create/{id}', ['as' => 'course-create', 'uses' => 'CoursesController@announcemntsCreate']);
    Route::post('/announcemnts/store', ['as' => 'course-create', 'uses' => 'CoursesController@announcemntsStore']);
    Route::get('/announcemnts/edit/{id}', ['as' => 'course-edit', 'uses' => 'CoursesController@announcemntsEdit']);
    Route::get('/announcemnts/statusUpdate/{id}', ['as' => 'course-edit', 'uses' => 'CoursesController@announcemntsStatusUpdate']);
    Route::post('/announcemnts/update/{id}', ['as' => 'course-edit', 'uses' => 'CoursesController@announcemntsUpdate']);
    Route::post('/announcemnts/destroy/{id}', ['as' => 'course-delete', 'uses' => 'CoursesController@announcemntsDestroy']);
    ///
});
