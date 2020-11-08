<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', 'API\AuthController@login');
    Route::post('/register', 'API\AuthController@register');
    Route::post('/password/forgot', 'API\AuthController@forgot');
    Route::post('/password/reset', 'API\AuthController@reset');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('/logout', 'API\AuthController@logout');
        Route::apiResource('/student', 'API\StudentController');
        Route::apiResource('/user', 'API\UserController');
        Route::apiResource('/tutor', 'API\TutorController');
    });
});
