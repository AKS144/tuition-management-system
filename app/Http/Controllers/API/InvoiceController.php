<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Invoice;
use App\BranchSetting;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:invoice-list'], ['only' => ['index']]);
        $this->middleware(['permission:invoice-create'], ['only' => ['store']]);
        $this->middleware(['permission:invoice-edit'], ['only' => ['update']]);
        $this->middleware(['permission:invoice-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoice = Invoice::all();

        return response([
            'status' => true,
            'invoice' => $invoice,
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
        $invoice = $request->all();
        $invoice['invoice_number'] = explode("-",$invoice->invoice_number);
        $invoice['invoice_number'] = $invoice_number[0].'-'.sprintf('%06d', intval($invoice_number[1]));

        $validator = Validator::make($invoice, [
            'name' => 'required|unique:invoices',
            'invoice_number' => 'required|unique:invoices,invoice_number',
            'due_date' => 'required',
            'student_id' => 'required',
            'branch_id' => 'required',
            'discount' => 'required',
            'discount_val' => 'required',
            'sub_total' => 'required',
            'total' => 'required',
            'tax' => 'required',
            'invoice_template_id' => 'required',
            'items' => 'required|array',
            'items.*' => 'required|max:255',
            'items.*.description' => 'max:255',
            'items.*.name' => 'required',
            'items.*.quantity' => 'required',
            'items.*.price' => 'required'
        ]);

        if($validator->fails()){
            return response([
                'status' => false,
                'error' => $validator->errors(),
                'message' => 'Validation Error'
            ], 401);
        }

        $invoice_date = Carbon::createFromFormat('d/m/Y', $request->invoice_date);
        $due_date = Carbon::createFromFormat('d/m/Y', $request->due_date);
        $status = Invoice::STATUS_DRAFT;
        $tax_per_item = BranchSetting::getSetting('tax_per_item', $request->branch_id) ?? 'NO';
        $discount_per_item = BranchSetting::getSetting('discount_per_item', $request->branch_id) ?? 'NO';

        if ($request->has('invoiceSend')) {
            $status = Invoice::STATUS_SENT;
        }

        $invoice = Invoice::create([
            'invoice_date' => $invoice_date,
            'due_date' => $due_date,
            'invoice_number' => $invoice['invoice_number'],
            'reference_number' => $request->reference_number,
            'user_id' => $request->user_id,
            'company_id' => $request->branch_id,
            'invoice_template_id' => $request->invoice_template_id,
            'status' => $status,
            'paid_status' => Invoice::STATUS_UNPAID,
            'sub_total' => $request->sub_total,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'discount_val' => $request->discount_val,
            'total' => $request->total,
            'due_amount' => $request->total,
            'tax_per_item' => $tax_per_item,
            'discount_per_item' => $discount_per_item,
            'tax' => $request->tax,
            'notes' => $request->notes,
            'unique_hash' => Str::random(60)
        ]);

        return response([
            'status' => true,
            'data' => $invoice,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
