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

Route::group(['prefix'=>'admin/users','middleware' => ['auth:' . UserGuard::GUARD_ADMIN]],function() {

    Route::get('/', ['as' => 'user-list', 'uses' => 'UsersController@index']);
    Route::get('/create', ['as' => 'user-create', 'uses' => 'UsersController@create']);
    Route::post('/store', ['as' => 'user-create', 'uses' => 'UsersController@store']);
    Route::get('/edit/{id}', ['as' => 'user-edit', 'uses' => 'UsersController@edit']);
    Route::get('/statusUpdate/{id}', ['as' => 'user-edit', 'uses' => 'UsersController@statusUpdate']);
    Route::post('/update/{id}', ['as' => 'user-edit', 'uses' => 'UsersController@update']);
    Route::post('/destroy/{id}', ['as' => 'user-delete', 'uses' => 'UsersController@destroy']);
/////////////////  user roles
    Route::get('/roles', ['as' => 'role-list', 'uses' => 'RoleController@index']);
    Route::get('/role/create', ['as' => 'role-create', 'uses' => 'RoleController@create']);
    Route::post('/role/store', ['as' => 'role-create', 'uses' => 'RoleController@store']);
    Route::get('/role/edit/{id}', ['as' => 'role-edit', 'uses' => 'RoleController@edit']);
    Route::post('/role/update/{id}', ['as' => 'role-edit', 'uses' => 'RoleController@update']);
    Route::post('/role/destroy/{id}', ['as' => 'role-delete', 'uses' => 'RoleController@destroy']);
///
/////////////////  students
    Route::get('/customers', ['as' => 'customers-list', 'uses' => 'StudentController@index']);
    Route::get('/customers/create', ['as' => 'customers-create', 'uses' => 'StudentController@create']);
    Route::post('/customers/store', ['as' => 'customers-create', 'uses' => 'StudentController@store']);
    Route::get('/customers/statusUpdate/{id}', ['as' => 'customers-edit', 'uses' => 'StudentController@statusUpdate']);
    Route::get('/customers/edit/{id}', ['as' => 'customers-edit', 'uses' => 'StudentController@edit']);
    Route::post('/customers/update/{id}', ['as' => 'customers-edit', 'uses' => 'StudentController@update']);
    Route::post('/customers/destroy/{id}', ['as' => 'customers-delete', 'uses' => 'StudentController@destroy']);

    /////////////////  students Educatiaons routes
    Route::get('/students/educations/{id}', ['as' => 'student-list', 'uses' => 'StudentController@education']);
    Route::get('/students/educations/create/{id}', ['as' => 'student-create', 'uses' => 'StudentController@educationCreate']);
    Route::post('/students/educations/store', ['as' => 'student-create', 'uses' => 'StudentController@educationStore']);
    Route::get('/students/educations/statusUpdate/{id}', ['as' => 'user-edit', 'uses' => 'StudentController@educationStatusUpdate']);
    Route::get('/students/educations/edit/{id}', ['as' => 'student-edit', 'uses' => 'StudentController@educationEdit']);
    Route::post('/students/educations/update/{id}', ['as' => 'student-edit', 'uses' => 'StudentController@educationUpdate']);
    Route::post('/students/educations/destroy/{id}', ['as' => 'student-delete', 'uses' => 'StudentController@educationDestroy']);
///
/////////////////  Insturctors
    Route::get('/instructors', ['as' => 'student-list', 'uses' => 'InsturctorsController@index']);
    Route::get('/instructors/create', ['as' => 'student-create', 'uses' => 'InsturctorsController@create']);
    Route::post('/instructors/store', ['as' => 'student-create', 'uses' => 'InsturctorsController@store']);
    Route::get('/instructors/statusUpdate/{id}', ['as' => 'user-edit', 'uses' => 'InsturctorsController@statusUpdate']);
    Route::get('/instructors/edit/{id}', ['as' => 'student-edit', 'uses' => 'InsturctorsController@edit']);
    Route::post('/instructors/update/{id}', ['as' => 'student-edit', 'uses' => 'InsturctorsController@update']);
    Route::post('/instructors/destroy/{id}', ['as' => 'student-delete', 'uses' => 'InsturctorsController@destroy']);

    /////////////////  Insturctors Exp routes
    Route::get('/instructors/exp/{id}', ['as' => 'student-list', 'uses' => 'InsturctorsController@exp']);
    Route::get('/instructors/exp/create/{id}', ['as' => 'student-create', 'uses' => 'InsturctorsController@expCreate']);
    Route::post('/instructors/exp/store', ['as' => 'student-create', 'uses' => 'InsturctorsController@expStore']);
    Route::get('/instructors/exp/statusUpdate/{id}', ['as' => 'user-edit', 'uses' => 'InsturctorsController@expStatusUpdate']);
    Route::get('/instructors/exp/edit/{id}', ['as' => 'student-edit', 'uses' => 'InsturctorsController@expEdit']);
    Route::post('/instructors/exp/update/{id}', ['as' => 'student-edit', 'uses' => 'InsturctorsController@expUpdate']);
    Route::post('/instructors/exp/destroy/{id}', ['as' => 'student-delete', 'uses' => 'InsturctorsController@expDestroy']);
///



});
