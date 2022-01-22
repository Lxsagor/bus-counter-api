<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRequest;
use App\Http\Resources\StaffResource;
use App\Models\Staff;
use Exception;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        try {

            $staffs = StaffResource::collection(Staff::paginate())->response()->getData();
            return response([
                'status' => 'success',
                'data'   => $staffs,
            ], 200);

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function store(StaffRequest $request)
    {
        try {

            $staff = Staff::create([
                'company_id' => auth()->user()->company_id,
                'image'      => request('image'),
                'name'       => request('name'),
                'address'    => request('address'),
                'phone'      => request('phone'),
                'details'    => request('details'),
                'docs'       => request('docs'),
            ]);
            return response([
                'status'     => 'success',
                'statusCode' => 201,
                'message'    => 'Successfully added Staff...',
                'data'       => StaffResource::make($staff),
            ]);

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function update(StaffRequest $request, $id)
    {
        try {

            $staff = Staff::where('_id', $id)->where('company_id', auth()->user()->company_id)->first();

            if ($staff) {
                $staff->image   = request('image') ?? $staff->image;
                $staff->name    = request('name') ?? $staff->name;
                $staff->address = request('address') ?? $staff->address;
                $staff->phone   = request('phone') ?? $staff->phone;
                $staff->details = request('details') ?? $staff->details;
                $staff->docs    = request('docs') ?? $staff->docs;

                $staff->update();

                return response([
                    'status'     => 'success',
                    'statusCode' => 202,
                    'message'    => 'Successfully update Staff...',
                    'data'       => StaffResource::make($staff),
                ]);
            } else {
                return itemNotFound();
            }

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function show($id)
    {
        try {
            $staff = Staff::where('_id', $id)->where('company_id', auth()->user()->company_id)->first();

            if ($staff) {
                return response([
                    'status' => 'success',
                    'data'   => StaffResource::make($staff),
                ]);

            } else {
                return itemNotFound();
            }

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function destroy($id)
    {
        try {
            $staff = Staff::where('_id', $id)->where('company_id', auth()->user()->company_id)->first();

            if ($staff) {
                $staff->delete();
                return response([
                    'status'  => 'success',
                    'message' => 'Staff deleted successfully',
                ], 202);
            } else {
                return itemNotFound();
            }

        } catch (Exception $e) {
            return serverError($e);
        }
    }
}
