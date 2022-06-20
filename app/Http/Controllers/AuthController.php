<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request){


//      return User::where('role','company')->get();


        $fields = $request->validate([
            'nic'=>'string',
            'name'=>'required|string',
            'Address'=>'required|string',
            'City'=>'required|string',
            'role'=>'required',
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string|confirmed'
        ]);



        $user=User::create([
            'nic'=>$fields['nic'] ?? null,
            'name'=>$fields['name'],
            'email'=>$fields['email'],
            'Address'=>$fields['Address'],
            'City'=>$fields['City'],
            'role'=>$fields['role'],
            'password'=>bcrypt($fields['password'])
        ]);


        $token = $user->createToken('myapptoken')->plainTextToken;



        $response=[
            'user'=>$user,
            'token'=>$token
        ];
        return response($response,201);
    }

    public function companyregister(Request $request){
        $fields= $request->validate([
            'name'=>'required|string',
            'Address'=>'required|string',
            'City'=>'required|string',
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string|confirmed'
        ]);

        $user=Company::create([
            'name'=>$fields['name'],
            'Address'=>$fields['Address'],
            'City'=>$fields['City'],
            'email'=>$fields['email'],
            'password'=>bcrypt($fields['password'])
        ]);



        $token = $user->createToken('myapptoken')->plainTextToken;

        $response=[
            'user'=>$user,
            'token'=>$token
        ];
        return response($response,201);
    }


    public function login(Request $request){
        $fields= $request->validate([

            'email'=>'required|string',
            'password'=>'required|string'
        ]);

       //Check Email
        $user=User::where('email',$fields['email'])->first();

        //check password
        if(!$user||!Hash::check($fields['password'],$user->password)){

            return response([
                'message'=>'Bad creds'
            ],401);

        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response=[
            'user'=>$user,
            'token'=>$token
        ];
        return response($response,201);
    }


    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return[
            'message'=>'Logged out'
        ];

    }

}
