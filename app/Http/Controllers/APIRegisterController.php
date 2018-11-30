<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use App\User;
use JWTFactory;
use JWTAuth;
use Illuminate\Support\Facades\Validator;


class APIRegisterController extends Controller
{
    public function register(Request $request){
        $rules=[
            'name' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $user= User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        $token=JWTAuth::fromUser($user);
        return response()->json(compact('token'));
    }
}
