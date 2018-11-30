<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;
use JWTFactory;
use JWTAuth;
use Illuminate\Support\Facades\Validator;
class APILoginController extends Controller
{
    public function login(Request $request){
        $rules=[
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required'],
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $credentials=$request->only('email','password');
        try{
            if(! $token=JWTAuth::attempt($credentials)){
                return response()->json(['error'=>'invalid email and password'],[401]);
            }
        }catch(JWTException $e){
            return response()->json(['error'=>'could not create token'],[500]);
        }
        return response()->json(compact('token'));
    }
}
