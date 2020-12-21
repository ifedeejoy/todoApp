<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        // validates user data
        $validateData = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);
        if ($validateData->fails()):
            return response(['status' => 'false', 'message' => 'User profile not created', 'errors'=>$validateData->errors()->all()], 400);
        endif;
        // hashes user password
        $request['password'] = bcrypt($request->password);
        
        $hash = Hash::make($request->password);
        // create user profile
        $user = User::create($request->toArray());
        // create access tokem
        $accessToken = $user->createToken('authToken')->accessToken;
        // return response
        return response(['status' => 'true', 'message' => 'User profile Created' , 'data' => $user, 'accessToken' => $accessToken], 201);
    }

    public function login(Request $request)
    {
        // validates user data
        $validateData = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        if ($validateData->fails()):
            return response(['status' => 'false', 'message' => 'Unable to complete user login', 'errors'=>$validateData->errors()->all()], 400);
        endif;
        // authenticate user
        if (!Auth::attempt($request->toArray())):
            return response(['status' => 'false', 'message' => 'Incorrect email or password, check your details'], 400);
        endif;

        $user = Auth::user();
        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['status' => 'true', 'message' => 'User login successful' ,'data'=> $user, 'access_token' => $accessToken]);
    }
}
