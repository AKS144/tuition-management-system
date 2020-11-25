<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subject = Subject::all();

        return response([
            'success' => true,
            'subject' => $subject
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
        $subject = $request->all();

        $validator = Validator::make($subject, [
            'name' => 'required|unique:subjects',
            'code' => 'required|unique:subjects'
        ]);

        if($validator->fails()){
            return response([
                'message' => $validator->errors()->first()
            ], 401);
        }

        $subject = Subject::create($subject);

        return response([
            'success' => true,
            'data' => $subject
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        return response([
            'success' => true,
            'data' => $subject
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $subject->update($request->all());

        return response([
            'success' => true,
            'data' => $subject
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return response([
            'success' => true
        ]);
    }
}
