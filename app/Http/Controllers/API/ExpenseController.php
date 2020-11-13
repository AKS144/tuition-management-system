<?php

namespace App\Http\Controllers\API;

use App\Expense;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:expense-list'], ['only' => ['index']]);
        $this->middleware(['permission:expense-create'], ['only' => ['store']]);
        $this->middleware(['permission:expense-edit'], ['only' => ['update']]);
        $this->middleware(['permission:expense-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expense = Expense::all();

        return response([
            'status' => true,
            'expense' => $expense,
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
        $expenses = $request->all();

        $validator = Validator::make($expenses, [
            'expense_date' => 'required',
            'expense_category_id' => 'required',
            'amount' => 'required'
        ]);

        if($validator->fails()){
            return response([
                'status' => false,
                'error' => $validator->errors(),
                'message' => 'Validation Error'
            ], 401);
        }

        $expenses = Expense::create($expenses);

        return response([
            'status' => true,
            'data' => $expenses,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        return response([
            'status' => true,
            'data' => $expense,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $expense->update($request->all());

        return response([
            'status' => true,
            'data' => $expense,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return response([
            'status' => true,
        ], 200);
    }
}
