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

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('/logout', 'API\AuthController@logout');
        Route::post('/password/reset', 'API\AuthController@reset');

        Route::apiResource('/student', 'API\StudentController');
        Route::apiResource('/user', 'API\UserController');
        Route::apiResource('/tutor', 'API\TutorController');
        Route::apiResource('/units', 'API\UnitController');
        Route::apiResource('/payment-methods', 'API\PaymentMethodController');
        Route::apiResource('/tax-types', 'API\TaxTypeController');
        Route::apiResource('/categories', 'API\ExpenseCategoryController');

        Route::fallback(function(){
            return response()->json([
                'message' => 'Invalid route, Please contact the administrator'
            ], 404);
        });
    });

    Route::fallback(function(){
        return response()->json([
            'message' => 'Invalid route, Please contact the administrator'
        ], 404);
    });
});