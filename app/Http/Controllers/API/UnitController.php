<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:unit-list'], ['only' => ['index']]);
        $this->middleware(['permission:unit-create'], ['only' => ['store']]);
        $this->middleware(['permission:unit-edit'], ['only' => ['update']]);
        $this->middleware(['permission:unit-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::all();

        return response([
            'status' => true,
            'units' => $units,
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
        $units = $request->all();

        $validator = Validator::make($units, [
            'name' => 'required|unique:units',
        ]);

        if($validator->fails()){
            return response([
                'status' => false,
                'error' => $validator->errors(),
                'message' => 'Validation Error'
            ], 401);
        }

        $units = Unit::create($units);

        return response([
            'status' => true,
            'data' => $units,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        return response([
            'status' => true,
            'data' => $unit,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
        $unit->update($request->all());

        return response([
            'status' => true,
            'data' => $unit,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();

        return response([
            'status' => true,
        ], 200);
    }
}