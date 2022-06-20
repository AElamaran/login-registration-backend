<?php

namespace App\Http\Controllers;
use App\Models\Company;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
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


}
