<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPassRequest;
use App\Http\Resources\UserResource;
use App\Models\Otp;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class ForgetPassController extends Controller
{
    public function forget(ForgetPassRequest $request)
    {

        try {

            $user = User::where('phone', request('phone'))->first();

            // dd($user);

            if ($user) {
                $otp = Otp::where('phone', $user->phone)->first();
                if ($otp) {
                    $otp->phone = $user->phone;
                    $otp->code  = $this->generateRandomString(6);
                    $otp->type  = Otp::FORGET;
                    $otp->update();
                } else {
                    $data = [
                        'phone' => $user->phone,
                        'code'  => $this->generateRandomString(6),
                        'type'  => Otp::FORGET,

                    ];

                    Otp::create($data);
                }

                $user->password_reset_request = true;
                $user->update();

                return response([
                    'status'  => 'success',
                    'message' => 'OTP send successfully',
                    // 'data'    => $otp,
                ], 200);

            } else {
                return itemNotFound('User not found', 401);
            }

        } catch (Exception $e) {
            return serverError($e);
        }

    }

    public function confirm()
    {
        try {

            $otp = Otp::where('phone', request('phone'))->where('code', request('code'))->first();
            if ($otp) {
                $user                         = User::where('phone', $otp->phone)->first();
                $user->password_reset_request = false;
                $user->update();
                $otp->delete();
                return response([
                    'status'  => 'success',
                    'message' => 'Confirmation success',
                    'data'    => UserResource::make($user),
                ], 200);
            } else {
                return itemNotFound('Code not matched', 401);
            }

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function resend(ForgetPassRequest $request)
    {
        try {
            $user = User::where('phone', request('phone'))->where('password_reset_request' == true)->first();
            // dd($user);
            if ($user) {
                $otp = Otp::where('phone', request('phone'))->first();
                if ($otp) {
                    $otp->code = $this->generateRandomString(6);
                    $otp->update();
                    return response([
                        'status'     => 'success',
                        'statusCode' => 202,
                        'message'    => 'Successfully resend OTP...',
                    ]);
                } else {
                    return itemNotFound('Send OTP first before resend OTP', 401);
                }

            } else {
                return itemNotFound('User not found', 401);
            }
        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function changePass()
    {
        try {
            $user = User::where('phone', request('phone'))->first();

            if ($user) {
                $user->password = Hash::make(request('password'));
                $user->update();
                return response([
                    'status'  => 'success',
                    'message' => 'Successfully changed password',
                    'data'    => UserResource::make($user),
                ]);
            } else {
                return itemNotFound();
            }
        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function generateRandomString($length)
    {
        $characters       = '0123456789';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
