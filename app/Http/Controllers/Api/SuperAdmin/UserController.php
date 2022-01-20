<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index($companyId)
    {
        try {
            $users = UserResource::collection(User::where('company_id', $companyId)->where('role_id', User::ADMIN)->paginate())->response()->getData();

            return response([
                'status' => 'success',
                'data'   => $users,
            ], 200);
        } catch (Exception $e) {
            return serverError($e);
        }
    }
    public function store(UserRequest $request, $companyId)
    {
        try {
            $user = User::create([
                'company_id' => $companyId,
                'role_id'    => User::ADMIN,
                'name'       => request('name'),
                'email'      => request('email'),
                'phone'      => request('phone'),
                'password'   => Hash::make(request('password')),
            ]);

            return response([
                'status'     => 'success',
                'statusCode' => 201,
                'message'    => 'Successfully added User..',
                'data'       => UserResource::make($user),
            ]);
        } catch (Exception $e) {
            return serverError($e);
        }
    }
    public function update($companyId, $id)
    {
        try {
            $user = User::where('_id', $id)->where('company_id', $companyId)->where('role_id', User::ADMIN)->first();
            if ($user) {
                $user->name = request('name') ?? $user->name;
                // $user->email    = request('email') ?? $user->email;
                // $user->phone    = request('phone') ?? $user->phone;
                // $user->password = Hash::make(request('password')) ?? $user->password;

                $user->update();

                return response([
                    'status'     => 'success',
                    'statusCode' => 202,
                    'message'    => 'Successfully update user...',
                    'data'       => UserResource::make($user),
                ]);
            } else {
                return itemNotFound();

            }
        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function show($companyId, $id)
    {
        try {
            $user = User::where('_id', $id)->where('company_id', $companyId)->where('role_id', User::ADMIN)->first();
            if ($user) {
                return response([
                    'status' => 'success',
                    'data'   => UserResource::make($user),
                ], 200);
            } else {
                return itemNotFound();
            }

        } catch (Exception $e) {
            return serverError($e);
        }
    }
    public function destroy($companyId, $id)
    {
        try {
            $user = User::where('_id', $id)->where('company_id', $companyId)->where('role_id', User::ADMIN)->first();

            if ($user) {
                $user->delete();
                return response([
                    'status'  => 'success',
                    'message' => 'User deleted successfully',
                ], 202);
            } else {
                return itemNotFound();
            }

        } catch (Exception $e) {
            return serverError($e);
        }
    }

}
