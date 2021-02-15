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

//Route::prefix('medialibrary')->group(function() {
    Route::group(['prefix'=>'admin/medialibrary','middleware' => ['auth:' . UserGuard::GUARD_ADMIN]],function() {
    Route::get('/', 'MediaLibraryController@index');
    Route::get('/media-library', 'MediaLibraryController@Library');
    Route::post('/save-file', 'MediaLibraryController@SaveFile');
    Route::post('/modal' , 'MediaLibraryController@modal');
    Route::post('/update/image_details' , 'MediaLibraryController@UpdateImage');
    Route::post('/bulk_select' , 'MediaLibraryController@bulkSelect');
    Route::get('/delete/image/{i}' , 'MediaLibraryController@DeleteImage');
    Route::post('/delete_bulk' , 'MediaLibraryController@DeleteBulk');
    Route::post('/filter' , 'MediaLibraryController@MediaFilteration');
    Route::post('/all_data' , 'MediaLibraryController@all_data');
});
