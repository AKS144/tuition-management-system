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


Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', 'API\AuthController@login');
    Route::post('/register', 'API\AuthController@register');
    Route::post('/password/forgot', 'API\AuthController@forgot');

    // Country, State & City
    //----------------------------------
    Route::get('/countries', [
        'as' => 'countries',
        'uses' => 'API\LocationController@getCountries'
    ]);

    Route::group(['middleware' => ['auth:api', 'cors']], function() {
        Route::get('/logout', 'API\AuthController@logout');
        Route::post('/password/reset', 'API\AuthController@reset');

        Route::resource('/student', 'API\StudentController');
        Route::apiResource('/user', 'API\UserController');
        Route::apiResource('/tutor', 'API\TutorController');

        // Units
        //----------------------------------
        Route::resource('/units', 'API\UnitController');

        // Payment Methods
        //----------------------------------
        Route::resource('/payment-methods', 'API\PaymentMethodController');

        // Tax Types
        //----------------------------------
        Route::resource('/tax-types', 'API\TaxTypeController');

        // Expense Categories
        //----------------------------------
        Route::resource('/categories', 'API\ExpenseCategoryController');

        // Expenses
        //----------------------------------
        Route::post('/expenses/delete', [
            'as' => 'expenses.delete',
            'uses' => 'ExpensesController@delete'
        ]);

        Route::get('/expenses/{id}/show/receipt', [
            'as' => 'expenses.show',
            'uses' => 'ExpensesController@showReceipt',
        ]);

        Route::post('/expenses/{id}/upload/receipts', [
            'as' => 'estimate.to.invoice',
            'uses' => 'ExpensesController@uploadReceipts'
        ]);

        Route::resource('/expenses', 'API\ExpenseController');

        // Invoice
        //----------------------------------
        Route::resource('/invoices', 'API\InvoiceController');

        // Payment
        //----------------------------------
        Route::resource('/payments', 'API\PaymentController');
    });

    // Route::fallback(function(){
    //     return response()->json([
    //         'message' => 'Invalid route, Please contact the administrator'
    //     ], 404);
    // });
});