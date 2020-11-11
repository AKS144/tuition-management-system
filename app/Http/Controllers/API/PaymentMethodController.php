<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Resources\PaymentMethodResource;
use Illuminate\Support\Facades\Validator;

class PaymentMethodController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:paymentMethod-list'], ['only' => ['index']]);
        $this->middleware(['permission:paymentMethod-create'], ['only' => ['store']]);
        $this->middleware(['permission:paymentMethod-edit'], ['only' => ['update']]);
        $this->middleware(['permission:paymentMethod-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentMethod = PaymentMethod::all();

        return response([
            'status' => true,
            'message' => 'Payment method successfully retrieved',
            'paymentMethod' => PaymentMethodResource::collection($paymentMethod),
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
        $paymentMethod = $request->all();

        $validator = Validator::make($paymentMethod, [
            'name' => 'required|unique:payment_methods',
            'branch_id' => 'required'
        ]);

        if($validator->fails()){
            return response([
                'status' => false,
                'error' => $validator->errors(),
                'message' => 'Validation Error'
            ], 401);
        }

        $paymentMethod = PaymentMethod::create($paymentMethod);

        return response([
            'status' => true,
            'data' => new PaymentMethodResource($paymentMethod),
            'message' => 'Payment method successfully created',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMethod $paymentMethod)
    {
        return response([
            'status' => true,
            'message' => 'Payment method successfully retrieved',
            'data' => new PaymentResource($paymentMethod),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $paymentMethod->update($request->all());

        return response([
            'status' => true,
            'message' => 'Payment method successfully updated',
            'data' => new PaymentMethodResource($paymentMethod),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        return response([
            'status' => true,
            'message' => 'Payment method successfully deleted'
        ], 200);
    }
}
