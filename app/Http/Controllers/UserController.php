<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        $fields= $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string|confirmed'
        ]);

        $user=User::create([
            'name'=>$fields['name'],
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

}
