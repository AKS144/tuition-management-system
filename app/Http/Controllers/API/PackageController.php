<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $package = Package::all();

        return response([
            'success' => true,
            'package' => $package
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
        $package = $request->all();

        $validator = Validator::make($package, [
            'name' => 'required|unique:packages',
            'type' => 'required',
            'amount' => 'required'
        ]);

        if($validator->fails()){
            return response([
                'message' => $validator->errors()->first()
            ], 401);
        }

        $package = Package::create($package);

        return response([
            'success' => true,
            'data' => $package
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        return response()->json([
            'success' => true,
            'data' => $package
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        $package->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $package
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        if(($package->subjectLevels() && $package->subjectLevels->count() > 0) ||
            ($package->students() && $package->students()->count() > 0)) {
            return response()->json([
                'success' => false
            ]);
        }
        
        $package->delete();

        return response([
            'success' => true
        ]);
    }
}
