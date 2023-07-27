<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    //register new user
    public function registerUser(Request $request){
        $request->validate([
            'name'=>'required|string',
            'email'=> 'required|string',
            'password'=> 'required|confirmed'
        ]);

        $user =User::where('email',$request->email)->first();
        if($user){
            return response()->json([
                'message'=>'email already exsits'
            ],400);
        }
        $user = User::create([
            'name'=>$request->name,
            'email' =>$request->email,
            'password'=>Hash::make($request->password)
        ]);
        return response()->json([
            'message'=>'user created successfully',
            'user' => [
                'id'=> $user->id,
                'name'=>$user->name,
                'email'=>$user->email
            ]
        ],201);
    }
    // login user and crate token
    public function login(Request $request){
        $request->validate([
            'email'=>'required | string',
            'password'=>'required|string'
        ]);
        $user = User::where('email',$request->email)->first();
        if(!$user || ! Hash::check($request->password,$user->password)){
            return response()->json([
                'message'=>'email or password not correct'
            ],401);
        }
        return response()->json([
            'message'=>'Logged success',
            'token' =>$user->createToken("Laravel api token")->plainTextToken,
            'user' => [
                'id'=> $user->id,
                'name'=>$user->name,
                'email'=>$user->email
            ]
        ],201);
    }
}
