<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Http\Request;
use App\Http\Resources\StudentResource;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:student-create|student-list|student-edit|student-delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()){
            $student = Student::all();

            return response([
                'status' => true,
                'message' => 'User successfully retrieved',
                'data' => StudentResource::collection($student),
            ], 200);
        } else {
            return response([
                'status' => false,
                'message' => 'Failed to retrieved user data'
            ], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $student = $request->all();

        $validator = Validator::make($student, [
            'full_name' => 'required',
            'nric' => 'required',
            'age' => 'required',
            'level' => 'required',
            'mobile_no' => 'required',
        ]);

        if($validator->fails()){
            return response([
                'status' => false,
                'error' => $validator->error(),
                'message' => 'Validation Error'
            ], 401);
        }

        $student = Student::create($student);

        return response([
            'status' => true,
            'data' => new StudentResource($student),
            'message' => 'User successfully created',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        if(auth()->user()){
            return response([
                'status' => true,
                'message' => 'User successfully retrieved',
                'data' => new StudentResource($student),
            ], 200);
        } else {
            return response([
                'status' => false,
                'message' => 'Failed to view the user details'
            ], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        if(auth()->user()){
            $student->update($request->all());

            return response([
                'status' => true,
                'message' => 'User successfully updated',
                'data' => new StudentResource($student),
            ], 200);
        } else {
            return response([
                'status' => false,
                'message' => 'Failed to update the user'
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        if(auth()->user()){
            $student->delete();

            return response([
                'status' => true,
                'message' => 'User successfully deleted'
            ], 200);
        } else {
            return response([
                'status' => false,
                'message' => 'Failed to delete the user'
            ], 401);
        }
    }
}
