<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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
            ], 422);
        }

        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        $user = User::create($input);
        // $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json([
            'status' => true,
            'user' => $user,
        ], 200);
    }

    public function login(Request $request){
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if($user){
            if(Hash::check($request->password, $user->password)){
                $accessToken = auth()->user()->createToken('authtoken')->accessToken;

                // successful authentication
                return response()->json([
                    'status' => true,
                    'user' => auth()->user(),
                    'access_token' => $accessToken
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Password mismatch'
                ], 422);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User does not exist!'
            ], 422);
        }
    }

    public function logout(Request $request){
        if(auth()->user()){
            $accessToken = auth()->user()->token()->revoke();

            return response([
                'status' => true,
                'message' => 'You have been successfully logged out!'
            ], 200);
        } else {
            return response([
                'status' => false,
                'message' => 'Unable to logout'
            ], 422);
        }
    }

    public function forgot(Request $request){
        $forgotData = $request->validate([
            'email' => 'email|required'
        ]);

        $validator = Validator::make($request->all(), $forgotData);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ], 401);
        }

        Password::sendResetLink($forgotData);

        return response()->json([
            'status' => true,
            'message' => 'Reset password link sent on your email id.',
        ], 200);
    }

    public function reset(Request $request){
        $resetData = $request->validate([
            'email' => 'email|required',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        $validator = Validator::make($request->all(), $resetData);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ], 400);
        }

        $reset_password_status = Password::reset($resetData, function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid token provided'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Password has been successfully changed',
        ], 200);
    }
}
