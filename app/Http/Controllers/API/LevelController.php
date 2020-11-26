<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $level = Level::all();

        return response([
            'status' => true,
            'level' => $level
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
        $level = $request->all();

        $validator = Validator::make($level, [
            'name' => 'required|unique:levels',

        ]);

        if($validator->fails()){
            return response([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 401);
        }

        $level = new Level();
        $level->name = $request->name;
        $level->save();

        return response([
            'level' => $level
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function show(Level $level)
    {
        return response([
            'level' => $level
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Crater\Level $Level
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $level = Level::findOrFail($id);

        return response()->json([
            'level' => $level
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $level = Level::findOrFail($id);
        $level->name = $request->name;
        $level->save();

        return response()->json([
            'level' => $level,
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $level = Level::find($id);
        if (($level->subjects() && $level->subjects()->count() > 0) || 
            ($level->subjectLevel() && $level->subjectLevel()->count() > 0)) {
            return response()->json([
                'success' => false
            ]);
        }

        $level->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
