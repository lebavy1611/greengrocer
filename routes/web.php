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

Route::get('/', function () {
    return view('welcome');
});
Route::group(['as' => 'api.', 'namespace' => 'Api\User'], function () {
    Route::get('/upload-to-dropbox','UploadImageController@uploadToDropbox');
    Route::post('/upload_to_dropbox','UploadImageController@uploadToDropboxFile');
});
