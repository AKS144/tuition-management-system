<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use App\Student;
use App\Currency;
use App\BranchSetting;
use App\Item;
use App\TaxType;
use App\PaymentMethod;
use App\Unit;
use App\Branch;
use Auth;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:user-list'], ['only' => ['index']]);
        $this->middleware(['permission:user-create'], ['only' => ['store']]);
        $this->middleware(['permission:user-edit'], ['only' => ['update']]);
        $this->middleware(['permission:user-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()){
            $user = User::all();

            return response([
                'status' => true,
                'message' => 'User successfully retrieved',
                'data' => UserResource::collection($user),
            ], 200);
        } else {
            return response([
                'status' => false,
                'message' => 'Failed to retrieved user data'
            ], 401);
        }
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
        $user = $request->all();

        $validator = Validator::make($user, [
            'full_name' => 'required',
            'email' => 'required|unique:App\User,email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'role' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'error' => $validator->errors(),
                'message' => 'Validation Error'
            ], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        $user = User::create($input);
        $user->assignRole($request->input('role'));

        return response([
            'status' => true,
            'data' => new UserResource($user),
            'message' => 'User successfully created',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if(auth()->user()){
            return response([
                'status' => true,
                'message' => 'User successfully retrieved',
                'data' => new UserResource($user),
            ], 200);
        } else {
            return response([
                'status' => false,
                'message' => 'Failed to view the user details'
            ], 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if(auth()->user()){
            $user->update($request->all());

            return response([
                'status' => true,
                'message' => 'User successfully updated',
                'data' => new UserResource($user),
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(auth()->user()){
            $user->delete();

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

    public function getBootstrap(Request $request)
    { 
        $user = Auth::user();

        $branch = $request->header('branch_id') ?? 1;

        $students = Student::whereBranch($branch)
            ->latest()
            ->get();
        
        $currencies = Currency::latest()->get();

        $default_language = BranchSetting::getSetting('language', $branch);

        $default_currency = Currency::findOrFail(
            BranchSetting::getSetting('currency', $branch)
        );

        $status = [
            ['key' => 'Active' , 'value' => '1'],
            ['key' => 'Not Active' , 'value' => '0'],
            ['key' => 'Terminated' , 'value' => '2'],
        ];

        $moment_date_format = BranchSetting::getSetting(
            'moment_date_format',
            $branch
        );

        $fiscal_year = BranchSetting::getSetting(
            'fiscal_year',
            $branch
        );

        $items = Item::with('taxes')
            ->whereBranch($request->header('branch_id'))
            ->get();

        $taxTypes = TaxType::latest()->get();

        $paymentMethods = PaymentMethod::latest()
            ->get();

        $units = Unit::latest()
            ->get();
        
        return response()->json([
            'user' => $user,
            'students' => $students,
            'currencies' => $currencies,
            'default_currency' => $default_currency,
            'default_language' => $default_language,
            'branch' => $user->branch,
            'branches' => Branch::all(),
            'items' => $items,
            'taxTypes' => $taxTypes,
            'moment_date_format' => $moment_date_format,
            'paymentMethods' => $paymentMethods,
            'units' => $units,
            'status' => $status,
            'fiscal_year' => $fiscal_year,
        ]);
    }
}
