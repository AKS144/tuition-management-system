<?php

namespace App\Http\Controllers\API;

use App\Expense;
use App\Currency;
use App\BranchSetting;
use Carbon\Carbon;
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
    public function index(Request $request)
    {
        $limit = $request->has('limit') ? $request->limit : 10;

        $expenses = Expense::with('category')
            ->join('expense_categories', 'expense_categories.id', '=', 'expenses.expense_category_id')
            ->applyFilters($request->only([
                'expense_category_id',
                'search',
                'from_date',
                'to_date',
                'orderByField',
                'orderBy'
            ]))
            ->whereBranch($request->branch_id)
            ->select('expenses.*', 'expense_categories.name')
            ->paginate($limit);
        
        return response()->json([
            'expenses' => $expenses,
            'currency' => Currency::findOrFail(
                BranchSetting::getSetting('currency', $request->branch_id)
            )
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $categories = ExpenseCategory::whereCompany($request->branch_id)->get();

        return response()->json([
            'categories' => $categories
        ]);
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

        $expense_date = Carbon::createFromFormat('d/m/Y', $request->expense_date);

        $expense = new Expense();
        $expense->notes = $request->notes;
        $expense->expense_category_id = $request->expense_category_id;
        $expense->amount = $request->amount;
        $expense->branch_id = $request->branch_id;
        $expense->expense_date = $expense_date;
        $expense->save();

        if ($request->hasFile('attachment_receipt')) {
            $expense->addMediaFromRequest('attachment_receipt')->toMediaCollection('receipts', 'local');
        }

        return response()->json([
            'expense' => $expense,
            'success' => true
        ]);
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
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, $id)
    {
        $categories = ExpenseCategory::whereCompany($request->branch_id)->get();
        $expense = Expense::with('category')->where('id', $id)->first();

        return response()->json([
            'categories' => $categories,
            'expense' => $expense
        ]);
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
        $expense_date = Carbon::createFromFormat('d/m/Y', $request->expense_date);

        $expense = Expense::findOrFail($expense->id);
        $expense->notes = $request->notes;
        $expense->expense_category_id = $request->expense_category_id;
        $expense->amount = $request->amount;
        $expense->expense_date = $expense_date;
        $expense->save();

        if ($request->hasFile('attachment_receipt')) {
            $expense->clearMediaCollection('receipts');
            $expense->addMediaFromRequest('attachment_receipt')->toMediaCollection('receipts', 'local');
        }

        return response()->json([
            'expense' => $expense,
            'success' => true
        ]);
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

    public function delete(Request $request)
    {
        Expense::destroy($request->id);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Upload the expense receipts to storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param   $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadReceipts(Request $request, $id)
    {
        $data = json_decode($request->attachment_receipt);

        if ($data) {
            $expense = Expense::find($id);

            if ($expense) {
                if ($request->type === 'edit') {
                    $expense->clearMediaCollection('receipts');
                }

                $expense->addMediaFromBase64($data->data)
                    ->usingFileName($data->name)
                    ->toMediaCollection('receipts', 'local');
            }
        }

        return response()->json([
            'success' => 'Expense receipts uploaded successfully'
        ]);
    }


    /**
     * Retrive details of an expense receipt from storage.
     * @param   int $id
     * @return  \Illuminate\Http\JsonResponse
     */
    public function showReceipt($id)
    {
        $expense = Expense::find($id);
        $imagePath  = null;

        if ($expense) {
            $media = $expense->getFirstMedia('receipts');
            if ($media) {
                $imagePath = $media->getPath();
            } else {
                return response()->json([
                    'error' => 'receipt_does_not_exist'
                ]);
            }
        }

        $type = \File::mimeType($imagePath);

        $image = 'data:' . $type . ';base64,' . base64_encode(file_get_contents($imagePath));

        return response()->json([
            'image' => $image,
            'type' => $type
        ]);
    }



    /**
     * Download an expense receipt from storage.
     * @param   int $id
     * @param   strig $hash
     * @return  \Symfony\Component\HttpFoundation\BinaryFileResponse | \Illuminate\Http\JsonResponse
     */
    public function downloadReceipt($id, $hash)
    {
        $branch = Branch::where('unique_hash', $hash)->first();

        $expense = Expense::whereBranch($branch->id)
            ->where('id', $id)
            ->first();
        $imagePath  = null;

        if ($expense) {
            $media = $expense->getFirstMedia('receipts');
            if ($media) {
                $imagePath = $media->getPath();
                $response = \Response::download($imagePath, $media->file_name);
                ob_end_clean();
                return $response;
            }
        }

        return response()->json([
            'error' => 'receipt_not_found'
        ]);
    }
}
