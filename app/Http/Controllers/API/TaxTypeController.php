<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\TaxType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaxTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:taxtype-list'], ['only' => ['index']]);
        $this->middleware(['permission:taxtype-create'], ['only' => ['store']]);
        $this->middleware(['permission:taxtype-edit'], ['only' => ['update']]);
        $this->middleware(['permission:taxtype-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taxTypes = TaxType::all();

        return response([
            'status' => true,
            'taxTypes' => $taxTypes,
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
        $taxTypes = $request->all();

        $validator = Validator::make($taxTypes, [
            'name' => 'required|unique:tax_types',
            'percent' => 'required|between:0, 99.99',

        ]);

        if($validator->fails()){
            return response([
                'status' => false,
                'error' => $validator->errors(),
                'message' => 'Validation Error'
            ], 401);
        }

        $taxTypes = TaxType::create($taxTypes);

        return response([
            'status' => true,
            'data' => $taxTypes,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TaxType  $taxType
     * @return \Illuminate\Http\Response
     */
    public function show(TaxType $taxType)
    {
        return response([
            'status' => true,
            'data' => $taxType,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TaxType  $taxType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaxType $taxType)
    {
        $taxType->update($request->all());

        return response([
            'status' => true,
            'data' => $taxType,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TaxType  $taxType
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaxType $taxType)
    {
        $taxType->delete();

        return response([
            'status' => true,
        ], 200);
    }
}
