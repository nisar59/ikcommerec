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

Route::group(['prefix'=>'curriculums','middleware' => ['auth']],function() {
    // Route::get('/', 'CategoryController@index');
    Route::get('/', ['as' => 'curriculum-list', 'uses' => 'CurriculumController@index']);
    Route::get('/create', ['as' => 'curriculum-create', 'uses' => 'CurriculumController@create']);
    Route::post('/store', ['as' => 'curriculum-create', 'uses' => 'CurriculumController@store']);
    Route::get('/edit/{id}', ['as' => 'curriculum-edit', 'uses' => 'CurriculumController@edit']);
    Route::get('/statusUpdate/{id}', ['as' => 'curriculum-edit', 'uses' => 'CurriculumController@statusUpdate']);
    Route::post('/update/{id}', ['as' => 'curriculum-edit', 'uses' => 'CurriculumController@update']);
    Route::post('/destroy/{id}', ['as' => 'curriculum-delete', 'uses' => 'CurriculumController@destroy']);

    //////////////////////////// sections route

    Route::get('/sections/{id}', ['as' => 'curriculum-list', 'uses' => 'CurriculumController@sections']);
    Route::get('/sections/create/{id}', ['as' => 'curriculum-create', 'uses' => 'CurriculumController@sectionCreate']);
    Route::post('/sections/store', ['as' => 'curriculum-create', 'uses' => 'CurriculumController@sectionStore']);
    Route::get('/sections/edit/{id}', ['as' => 'curriculum-edit', 'uses' => 'CurriculumController@sectionEdit']);
    Route::get('/sections/statusUpdate/{id}', ['as' => 'curriculum-edit', 'uses' => 'CurriculumController@statusSectionUpdate']);
    Route::post('/sections/update/{id}', ['as' => 'curriculum-edit', 'uses' => 'CurriculumController@sectionUpdate']);
    Route::post('/sections/destroy/{id}', ['as' => 'curriculum-delete', 'uses' => 'CurriculumController@sectionDestroy']);


    //////////////////////////// lessons route

    Route::get('/sections/lesson/{id}', ['as' => 'curriculum-list', 'uses' => 'CurriculumController@lessons']);
    Route::get('/sections/lesson/create/{id}', ['as' => 'curriculum-create', 'uses' => 'CurriculumController@lessonCreate']);
    Route::post('/sections/lesson/store', ['as' => 'curriculum-create', 'uses' => 'CurriculumController@lessonStore']);
    Route::get('/sections/lesson/edit/{id}', ['as' => 'curriculum-edit', 'uses' => 'CurriculumController@lessonEdit']);
    Route::get('/sections/lesson/statusUpdate/{id}', ['as' => 'curriculum-edit', 'uses' => 'CurriculumController@statuslessonUpdate']);
    Route::post('/sections/lesson/update/{id}', ['as' => 'curriculum-edit', 'uses' => 'CurriculumController@lessonUpdate']);
    Route::post('/sections/lesson/destroy/{id}', ['as' => 'curriculum-delete', 'uses' => 'CurriculumController@lessonnDestroy']);
});

