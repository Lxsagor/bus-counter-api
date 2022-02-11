<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('phone', request('phone'))->first();

            if (!Hash::check(request('password'), $user->password)) {
                return itemNotFound('Credientials not matched', 401);
            }

            $token = $user->createToken('authToken');

            return response([
                'status'     => 'success',
                'statusCode' => 200,
                'message'    => 'Successfully login...',
                'data'       => [
                    'token' => 'Bearer ' . $token->plainTextToken,
                    'user'  => UserResource::make($user),
                ],
            ]);
        } catch (Exception $e) {
            return serverError($e);
        }
    }
    public function logout()
    {
        try {

            $auth = Auth::user();

            $auth->tokens()->delete();

            return response([
                'status'  => 'success',
                'message' => 'Successfully logout...',
            ], 200);
        } catch (Exception $e) {
            return serverError($e);
        }
    }

    // public function me()
    // {
    //     try {
    //         $user = User::where('id', auth()->id())->first();
    //         return response([
    //             'status' => 'success',
    //             'user'   => $user,
    //         ], 200);
    //     } catch (Exception $e) {
    //         return serverError($e);
    //     }
    // }

}