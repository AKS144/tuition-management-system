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
            'packages' => $package
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
            'package' => $package
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
            'package' => $package
        ]);
    }

    public function edit($id)
    {
        $package = Package::findOrFail($id);

        return response()->json([
            'package' => $package
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        $package->name = $request->name;
        $package->type = $request->type;
        $package->amount = $request->amount;
        $package->save();

        return response()->json([
            'packages' => $package,
            'success' => true
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
