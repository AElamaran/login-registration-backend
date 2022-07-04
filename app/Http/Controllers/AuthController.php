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
            'nic'=>'string|unique:users',
            'name'=>'required|string',
            'Address'=>'required|string',
            'Contact_number'=>'required|string',
            'Vehicle_type' =>'string',
            'Vehicle_brand' => 'string',
            'Vehicle_color' => 'string',
            'Vehicle_number' => 'string',
           'Numberofpassenger' => 'string',
            'role'=>'required',
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string|confirmed'
        ]);



        $user=User::create([
            'nic'=>$fields['nic'] ?? null,
            'name'=>$fields['name'],
            'email'=>$fields['email'],
            'Vehicle_type'=>$fields['Vehicle_type'] ?? null,
            'Vehicle_brand'=>$fields['Vehicle_brand'] ?? null,
            'Vehicle_color'=>$fields['Vehicle_color'] ?? null,
            'Vehicle_number'=>$fields['Vehicle_number'] ?? null,
            'Numberofpassenger'=>$fields['Numberofpassenger'] ?? null,
            'Address'=>$fields['Address'],
            'Contact_number'=>$fields['Contact_number'],
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
