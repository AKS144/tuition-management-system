<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        $rules = [
            'full_name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required',
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        $user = User::create($input);
        // $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json([
            'status' => true,
            'user' => $user,
            // 'access_token' => $accessToken,
            'status_code' => 1000
        ], 200);
    }

    public function login(Request $request){
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        
        // If authentication is unsuccessful
        if(!auth()->attempt($loginData)){
            return response()->json([
                'status' => false,
                'message' => 'invalid Credentials',
                'status_code' => 1001
            ], 401);
        }

        $accessToken = auth()->user()->createToken('authtoken')->accessToken;

        // successful authentication
        return response()->json([
            'status' => true,
            'user' => auth()->user(),
            'access_token' => $accessToken
        ], 200);
    }

    public function logout(Request $request){
        if(auth()->user()){
            $accessToken = auth()->user()->token()->revoke();

            return response([
                'status' => true,
                'message' => 'Logout successsfully'
            ], 200);
        } else {
            return response([
                'status' => false,
                'message' => 'Unable to logout'
            ], 401);
        }
    }
}
