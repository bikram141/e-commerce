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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/admin')->namespace('Admin')->group(function(){
    // Route::any('/', 'AdminController@login');
    // Route::get('/', 'AdminController@login');
    Route::any('/','AdminController@login');
    Route::group(['middleware'=>['admin']],function(){
    Route::get('dashboard','AdminController@dashboard');
    Route::get('settings','AdminController@settings');
    Route::get('logout','AdminController@logout');
    Route::post('check-current-pwd','AdminController@chkCurrentPassword');
    Route::post('update-current-pwd','AdminController@updateCurrentPassword');
    Route::any('update-admin-details','AdminController@updateAdminDetails');
    });
});
