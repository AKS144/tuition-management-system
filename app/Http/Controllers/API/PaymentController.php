<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Payment;
use App\Invoice;
use App\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:payment-list'], ['only' => ['index']]);
        $this->middleware(['permission:payment-create'], ['only' => ['store']]);
        $this->middleware(['permission:payment-edit'], ['only' => ['update']]);
        $this->middleware(['permission:payment-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit = $request->has('limit') ? $request->limit : 10;

        $payments = Payment::with(['student', 'invoice', 'paymentMethod'])
            ->join('students', 'students.id', '=', 'payments.user_id')
            ->leftJoin('invoices', 'invoices.id', '=', 'payments.invoice_id')
            ->leftJoin('payment_methods', 'payment_methods.id', '=', 'payments.payment_method_id')
            ->applyFilters($request->only([
                'search',
                'payment_number',
                'payment_method_id',
                'customer_id',
                'orderByField',
                'orderBy'
            ]))
            ->whereBranch($request->branch_id)
            ->select('payments.*', 'students.name', 'invoices.invoice_number', 'payment_methods.name as payment_mode')
            ->latest()
            ->paginate($limit);

        return response()->json([
            'payments' => $payments
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
