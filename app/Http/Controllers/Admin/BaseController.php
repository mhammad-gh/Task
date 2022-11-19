<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {

        if (is_numeric($request->Email)) {
            $validator = Validator::make($request->all(), [
                'First_Name' => 'required|string|min:2|max:100',
                'Last_Name' => 'required|string|min:2|max:100',
                'Email' => 'required|regex:/^0[6-9][0-9]/|digits:10|unique:users',
                'Password' => 'required|string|min:6|max:10',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'First_Name' => 'required|string|min:2|max:100',
                'Last_Name' => 'required|string|min:2|max:100',
                'Email' => 'required|string|email|max:100|unique:users',
                'Password' => 'required|string|min:6|max:10',
            ]);
        }

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->First_Name . ' ' . $request->Last_Name,
            'email' => $request->Email,
            'password' => Hash::make($request->Password),
        ]);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        if (is_numeric($request->email)) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|regex:/^0[6-9][0-9]/',
                'password' => 'required|string|min:6|max:10',
            ]);
        } else { $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:10',
        ]);}

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth::attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth::factory()->getTTL() * 60,
        ]);
    }

}
