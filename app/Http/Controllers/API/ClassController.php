<?php

namespace App\Http\Controllers\API;

use App\Classroom;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->has('limit') ? $request->limit : 10;
        
        $class = Classroom::with(['tutor'])
            ->applyFilters($request->only([
                'search',
                'name',
                'code',
                'batch_year',
                'orderByField',
                'orderBy'
            ]))
            ->whereBranch($request->header('branch'))
            ->groupBy('classrooms.id')
            ->paginate($limit);

        return response()->json([
            'class' => $class
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
        $class = $request->all();

        $validator = Validator::make($class, [
            'name' => 'required',
            'code' => 'required',
            'batch_year' => 'required',
            'tutor_id' => 'required',
        ]);

        if($validator->fails()){
            return response([
                'status' => false,
                'error' => $validator->errors(),
                'message' => 'Validation Error'
            ], 401);
        }

        $class = Classroom::create($class);

        return response([
            'status' => true,
            'data' => $class,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom $class)
    {
        return response([
            'status' => true,
            'data' => $class,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classroom $class)
    {
        $class->update($request->all());

        return response([
            'status' => true,
            'data' => $class,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classroom $classroom)
    {
        $classroom->delete();

        return response([
            'status' => true,
        ], 200);
    }
}
