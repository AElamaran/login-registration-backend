<?php

namespace App\Http\Controllers;



use App\ApiCode;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Password;


class ForgotPasswordController extends Controller
{
    public function forgot()
    {
        $credentials = request()->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($credentials);


        if ($status == Password::RESET_LINK_SENT) {
            return [
                'status' => __($status)
            ];
        }

        $response = [
            'response' => [trans($status)]

        ];

        return response($response, 404);
    }


    public function reset(ResetPasswordRequest $request)
    {
        $reset_password_status = Password::reset($request->validated(), function ($user, $password) {
            $user->password = bcrypt($password);
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            $response = [
                'response' => [trans($reset_password_status)]
            ];

            return response($response, 403);
        }

        $response = [
            'response' => [trans($reset_password_status)]
        ];

        return response($response, 200);
    }
}
