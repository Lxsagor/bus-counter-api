<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegRequest;
use App\Models\Profile;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class RegController extends Controller
{
    public function register(RegRequest $request)
    {
        try {
            $user = User::create([
                'name'     => request('name'),
                'email'    => request('email'),
                'phone'    => request('phone'),
                'role_id'  => 4,
                'password' => Hash::make(request('password')),

            ]);
            if ($user) {
                $data = [
                    'user_id' => $user->_id,
                    'phone'   => request('phone'),
                    'gender'  => request('gender'),
                    'city'    => request('city'),
                    'dob'     => request('dob'),
                ];

                Profile::create($data);

                return response([
                    'status'     => 'done',
                    'statusCode' => 201,
                    'message'    => 'Successfully registered...',
                ]);

            }
        } catch (Exception $e) {
            return serverError($e);
        }
    }
}
