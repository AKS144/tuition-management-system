<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Tutor;
use Illuminate\Http\Request;
use App\Http\Resources\TutorResource;
use Illuminate\Support\Facades\Validator;

class TutorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:tutor-list'], ['only' => ['index']]);
        $this->middleware(['permission:tutor-create'], ['only' => ['store']]);
        $this->middleware(['permission:tutor-edit'], ['only' => ['update']]);
        $this->middleware(['permission:tutor-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $tutors = Tutor::whereBranch($request->header('branch'))
            ->latest()
            ->get();
        
        return response()->json([
            'tutors' => $tutors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tutor = $request->all();

        $validator = Validator::make($tutor, [
            'full_name' => 'required',
            'mobile_no' => 'required|regex:/(01)[0-9]{9}',
            'age' => 'required|numeric',
            'address' => 'required',
            'experience' => 'required|numeric',
            'date_employed' => '|date_format:Y-m-d H:i:s',
            'branch_id' => 'required|numeric',
        ]);

        if($validator->fails()){
            return response([
                'status' => false,
                'error' => $validator->errors(),
                'message' => 'Validation Error'
            ], 401);
        }

        $tutor = Tutor::create($tutor);

        return response([
            'status' => true,
            'data' => new TutorResource($tutor),
            'message' => 'Tutor successfully created',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tutor  $tutor
     * @return \Illuminate\Http\Response
     */
    public function show(Tutor $tutor)
    {
        if(auth()->user()){
            return response([
                'status' => true,
                'message' => 'Tutor successfully retrieved',
                'data' => new TutorResource($tutor),
            ], 200);
        } else {
            return response([
                'status' => false,
                'message' => 'Failed to view the tutor details'
            ], 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tutor  $tutor
     * @return \Illuminate\Http\Response
     */
    public function edit(Tutor $tutor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tutor  $tutor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tutor $tutor)
    {
        if(auth()->user()){
            $tutor->update($request->all());

            return response([
                'status' => true,
                'message' => 'Tutor successfully updated',
                'data' => new TutorResource($tutor),
            ], 200);
        } else {
            return response([
                'status' => false,
                'message' => 'Failed to update the tutor'
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tutor  $tutor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tutor $tutor)
    {
        if(auth()->user()){
            $tutor->delete();

            return response([
                'status' => true,
                'message' => 'Tutor successfully deleted'
            ], 200);
        } else {
            return response([
                'status' => false,
                'message' => 'Failed to delete the tutor'
            ], 401);
        }
    }
}
