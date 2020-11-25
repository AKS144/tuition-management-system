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
    public function index(Request $request)
    {
        $limit = $request->has('limit') ? $request->limit : 10;

        $invoices = Invoice::with(['items', 'student', 'invoiceTemplate', 'taxes'])
            ->join('students', 'students.id', '=', 'invoices.student_id')
            ->applyFilters($request->only([
                'status',
                'paid_status',
                'student_id',
                'invoice_number',
                'from_date',
                'to_date',
                'orderByField',
                'orderBy',
                'search',
            ]))
            ->whereBranch($request->header('branch'))
            ->select('invoices.*', 'students.name')
            ->latest()
            ->paginate($limit);

        return response([
            'status' => true,
            'invoice' => $invoices,
        ], 200);
    }

    public function create(Request $request)
    {
        $tax_per_item = BranchSetting::getSetting('tax_per_item', $request->header('branch'));
        $discount_per_item = BranchSetting::getSetting('discount_per_item', $request->header('branch'));
        $invoice_prefix = BranchSetting::getSetting('invoice_prefix', $request->header('branch'));
        $invoice_num_auto_generate = BranchSetting::getSetting('invoice_auto_generate', $request->header('branch'));

        $nextInvoiceNumberAttribute = null;
        $nextInvoiceNumber = Invoice::getNextInvoiceNumber($invoice_prefix);

        if ($invoice_num_auto_generate == "YES") {
            $nextInvoiceNumberAttribute = $nextInvoiceNumber;
        }

        return response()->json([
            'nextInvoiceNumberAttribute' => $nextInvoiceNumberAttribute,
            'nextInvoiceNumber' => $invoice_prefix.'-'.$nextInvoiceNumber,
            'items' => Item::with('taxes')->whereBranch($request->header('branch'))->get(),
            'invoiceTemplates' => InvoiceTemplate::all(),
            'tax_per_item' => $tax_per_item,
            'discount_per_item' => $discount_per_item,
            'invoice_prefix' => $invoice_prefix
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
        $invoice = $request->all();
        $invoice['invoice_number'] = explode("-",$invoice->invoice_number);
        $invoice['invoice_number'] = $invoice_number[0].'-'.sprintf('%06d', intval($invoice_number[1]));

        $validator = Validator::make($invoice, [
            'name' => 'required|unique:invoices',
            'invoice_number' => 'required|unique:invoices,invoice_number',
            'due_date' => 'required',
            'student_id' => 'required',
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
        $tax_per_item = BranchSetting::getSetting('tax_per_item', $request->header('branch')) ?? 'NO';
        $discount_per_item = BranchSetting::getSetting('discount_per_item', $request->header('branch')) ?? 'NO';

        if ($request->has('invoiceSend')) {
            $status = Invoice::STATUS_SENT;
        }

        $invoice = Invoice::create([
            'invoice_date' => $invoice_date,
            'due_date' => $due_date,
            'invoice_number' => $invoice['invoice_number'],
            'reference_number' => $request->reference_number,
            'user_id' => $request->user_id,
            'branch_id' => $request->header('branch'),
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

        $invoiceItems = $request->items;

        foreach ($invoiceItems as $invoiceItem) {
            $invoiceItem['branch_id'] = $request->header('branch');
            $item = $invoice->items()->create($invoiceItem);

            if (array_key_exists('taxes', $invoiceItem) && $invoiceItem['taxes']) {
                foreach ($invoiceItem['taxes'] as $tax) {
                    $tax['branch_id'] = $request->header('branch');
                    if (gettype($tax['amount']) !== "NULL") {
                        $item->taxes()->create($tax);
                    }
                }
            }
        }

        if ($request->has('taxes')) {
            foreach ($request->taxes as $tax) {
                $tax['branch_id'] = $request->header('branch');

                if (gettype($tax['amount']) !== "NULL") {
                    $invoice->taxes()->create($tax);
                }
            }
        }

        // if ($request->has('invoiceSend')) {
        //     $data['invoice'] = Invoice::findOrFail($invoice->id)->toArray();
        //     // $data['user'] = User::find($request->user_id)->toArray();
        //     $data['parent'] = Parent::with('student')
        //                         ->whereStudent($request->student_id)
        //                         ->get();
        //     $data['branch'] = Branch::find($invoice->branch_id);

        //     $email = $data['parent']['email'];

        //     if (!$email) {
        //         return response()->json([
        //             'error' => 'user_email_does_not_exist'
        //         ]);
        //     }

        //     \Mail::to($email)->send(new InvoicePdf($data));
        // }

        $invoice = Invoice::with(['items', 'user', 'invoiceTemplate', 'taxes'])->find($invoice->id);

        return response()->json([
            'url' => url('/invoices/pdf/'.$invoice->unique_hash),
            'invoice' => $invoice
        ]);
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
