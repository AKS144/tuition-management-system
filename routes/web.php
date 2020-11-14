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

Route::get('/{vue?}', function () {
    return view('app');
})->where('vue', '[\/\w\.-]*');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

// Route::group(['middleware' => ['auth']], function() {
//     Route::resources('roles', 'RoleController');
//     Route::resources('users', 'UserController');
//     Route::resources('tutor', 'TutorController');
// });
// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/storage/{extra}', function ($extra) {
    return redirect('/public/storage/$extra');
})->where('extra', '.*');