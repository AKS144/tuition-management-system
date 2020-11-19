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

        Route::apiResource('/user', 'API\UserController');
        Route::apiResource('/tutor', 'API\TutorController');

        // Student
        //----------------------------------

        Route::resource('/students', 'API\StudentController');

        // Classroom
        //----------------------------------

        Route::resource('/class', 'API\ClassController');

        // Bootstrap
        //----------------------------------

        Route::get('/bootstrap', [
            'as' => 'bootstrap',
            'uses' => 'API\UserController@getBootstrap'
        ]);

        // Dashboard
        //----------------------------------

        Route::get('/dashboard', [
            'as' => 'dashboard',
            'uses' => 'API\DashboardController@index'
        ]);

        // Units
        //----------------------------------
        Route::resource('/units', 'API\UnitController');

        // Payment Methods
        //----------------------------------
        Route::resource('/payment-methods', 'API\PaymentMethodController');

        // Tax Types
        //----------------------------------
        Route::resource('/tax-types', 'API\TaxTypeController');

        // Levels
        //----------------------------------
        Route::resource('/levels', 'API\LevelController');

        // Subjects
        //----------------------------------
        Route::resource('/subjects', 'API\SubjectController');

        // Expense Categories
        //----------------------------------
        Route::resource('/categories', 'API\ExpenseCategoryController');

        // Expenses
        //----------------------------------
        Route::post('/expenses/delete', [
            'as' => 'expenses.delete',
            'uses' => 'API\ExpensesController@delete'
        ]);

        Route::get('/expenses/{id}/show/receipt', [
            'as' => 'expenses.show',
            'uses' => 'API\ExpensesController@showReceipt',
        ]);

        Route::post('/expenses/{id}/upload/receipts', [
            'as' => 'estimate.to.invoice',
            'uses' => 'API\ExpensesController@uploadReceipts'
        ]);

        Route::resource('/expenses', 'API\ExpenseController');

        // Invoice
        //----------------------------------
        Route::resource('/invoices', 'API\InvoiceController');

        // Payment
        //----------------------------------
        Route::post('/payments/delete', [
            'as' => 'payments.delete',
            'uses' => 'API\PaymentController@delete'
        ]);

        Route::post('/payments/send', [
            'as' => 'payments.send',
            'uses' => 'PaymentController@sendPayment'
        ]);

        Route::resource('/payments', 'API\PaymentController');

        // Items
        //----------------------------------

        Route::post('/items/delete', [
            'as' => 'items.delete',
            'uses' => 'API\ItemController@delete'
        ]);

        Route::resource('items', 'API\ItemController');

        // Settings
        //----------------------------------
        Route::group(['prefix' => 'settings'], function () {
            Route::get('/general', [
                'as' => 'get.admin.branch.setting',
                'uses' => 'API\SettingsController@getGeneralSettings'
            ]);
        });
    });

    // Route::fallback(function(){
    //     return response()->json([
    //         'message' => 'Invalid route, Please contact the administrator'
    //     ], 404);
    // });
});