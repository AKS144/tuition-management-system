<?php

namespace App\Http\Controllers\API;

use App\ExpenseCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ExpenseCategoryResource;
use Illuminate\Support\Facades\Validator;

class ExpenseCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:expenseCategory-list'], ['only' => ['index']]);
        $this->middleware(['permission:expenseCategory-create'], ['only' => ['store']]);
        $this->middleware(['permission:expenseCategory-edit'], ['only' => ['update']]);
        $this->middleware(['permission:expenseCategory-delete'], ['only' => ['destroy']]);
    }

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
            'message' => 'Expense category successfully retrieved',
            'expenseCategory' => ExpenseCategoryResource::collection($expenseCategory),
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
            'description' => 'nullable',
            'branch_id' => 'nullable',
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
            'data' => new ExpenseCategoryResource($expenseCategory),
            'message' => 'Expense category successfully created',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseCategory $expenseCategory)
    {
        return response([
            'status' => true,
            'message' => 'Expense category successfully retrieved',
            'data' => new ExpenseCategoryResource($expenseCategory),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        $expenseCategory->update($request->all());

        return response([
            'status' => true,
            'message' => 'Expense category successfully updated',
            'data' => new ExpenseCategoryResource($expenseCategory),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();

        return response([
            'status' => true,
            'message' => 'Expense category successfully deleted'
        ], 200);
    }
}
