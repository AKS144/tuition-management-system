<?php

namespace App\Http\Controllers\API;

use App\ExpenseCategory;
use App\Expense;
use App\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenseCategory = ExpenseCategory::all();

        return response([
            'status' => true,
            'data' => $expenseCategory,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $expenseCategory = $request->all();

        $validator = Validator::make($expenseCategory, [
            'name' => 'required|unique:expense_categories',
        ]);

        if($validator->fails()){
            return response([
                'status' => false,
                'error' => $validator->errors(),
                'message' => 'Validation Error'
            ], 401);
        }

        $expenseCategory = ExpenseCategory::create($expenseCategory);

        return response([
            'status' => true,
            'data' => $expenseCategory,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExpenseCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseCategory $category)
    {
        return response([
            'status' => true,
            'data' => $category,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExpenseCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseCategory $category)
    {
        $category->update($request->all());

        return response([
            'status' => true,
            'data' => $category,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpenseCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseCategory $category)
    {
        $category->delete();

        return response([
            'status' => true,
        ], 200);
    }
}
