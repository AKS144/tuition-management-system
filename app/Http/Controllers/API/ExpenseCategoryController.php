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
            'categories' => $expenseCategory,
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
                'message' => $validator->errors()->first,
            ], 401);
        }

        $category = new ExpenseCategory();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->branch_id = $request->header('branch');
        $category->save();

        return response([
            'status' => true,
            'category' => $category,
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
            'category' => $category,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Crater\ExpensesCategory $ExpensesCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = ExpenseCategory::findOrFail($id);

        return response()->json([
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExpenseCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = ExpenseCategory::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return response()->json([
            'category' => $category,
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpenseCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = ExpenseCategory::find($id);
        if ($category->expenses() && $category->expenses()->count() > 0) {
            return response()->json([
                'success' => false
            ]);
        }
        $category->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
