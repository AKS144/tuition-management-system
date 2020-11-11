<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Taxtype;
use Illuminate\Http\Request;
use App\Http\Resources\TaxTypeResource;
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
        $taxType = Unit::all();

        return response([
            'status' => true,
            'message' => 'Tax type successfully retrieved',
            'taxTypes' => TaxTypeResource::collection($taxType),
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
        $taxType = $request->all();

        $validator = Validator::make($taxType, [
            'name' => 'required|unique:tax_types',
            'percent' => 'required|between:0, 99.99',
            'compound_tax' => 'nullable|min:0|max:1',
            'collective_tax' => 'nullable|min:0|max:1',
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

        $taxType = TaxType::create($taxType);

        return response([
            'status' => true,
            'data' => new TaxTypeResource($taxType),
            'message' => 'Tax type successfully created',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Taxtype  $taxtype
     * @return \Illuminate\Http\Response
     */
    public function show(Taxtype $taxtype)
    {
        return response([
            'status' => true,
            'message' => 'Tax type successfully retrieved',
            'data' => new TaxTypeResource($taxtype),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Taxtype  $taxtype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Taxtype $taxtype)
    {
        $taxtype->update($request->all());

        return response([
            'status' => true,
            'message' => 'Tax type successfully updated',
            'data' => new TaxTypeResource($taxtype),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Taxtype  $taxtype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Taxtype $taxtype)
    {
        $taxtype->delete();

        return response([
            'status' => true,
            'message' => 'Tax type successfully deleted'
        ], 200);
    }
}
