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
    public function index(Request $request)
    {
        $taxTypes = TaxType::whereBranch($request->header('branch'))
            ->latest()
            ->get();

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
                'message' => $validator->errors()->first()
            ], 401);
        }

        $taxType = new TaxType();
        $taxType->name = $request->name;
        $taxType->percent = $request->percent;
        $taxType->description = $request->description;
        if ($request->has('compound_tax')) {
            $taxType->compound_tax = $request->compound_tax;
        }
        $taxType->branch_id = $request->header('branch');
        $taxType->save();

        return response()->json([
            'taxType' => $taxType,
        ]);
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
     * Show the form for editing the specified resource.
     *
     * @param  \Crater\TaxType  $taxType
     * @return \Illuminate\Http\Response
     */
    public function edit(TaxType $taxType)
    {
        return response()->json([
            'taxType' => $taxType
        ]);
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
        $taxTypes = $request->all();

        $validator = Validator::make($taxTypes, [
            'name' => 'required|unique:tax_types',
            'percent' => 'required|between:0, 99.99',

        ]);

        if($validator->fails()){
            return response([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 401);
        }

        $taxType->name = $request->name;
        $taxType->percent = $request->percent;
        $taxType->description = $request->description;
        if ($request->has('collective_tax')) {
            $taxType->collective_tax = $request->collective_tax;
        }
        $taxType->compound_tax = $request->compound_tax;
        $taxType->save();

        return response()->json([
            'taxType' => $taxType,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TaxType  $taxType
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaxType $taxType)
    {
        if ($taxType->taxes() && $taxType->taxes()->count() > 0) {
            return response()->json([
                'success' => false
            ]);
        }
        $taxType->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
