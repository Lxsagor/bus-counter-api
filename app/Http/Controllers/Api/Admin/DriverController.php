<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DriverRequest;
use App\Http\Resources\DriverResource;
use App\Models\Driver;
use Exception;

class DriverController extends Controller
{
    public function index()
    {
        try {

            $drivers = DriverResource::collection(Driver::paginate())->response()->getData();
            return response([
                'status' => 'success',
                'data'   => $drivers,
            ], 200);

        } catch (Exception $e) {
            return serverError($e);
        }
    }
    public function get()
    {
        try {

            $drivers = Driver::get();
            return response([
                'status' => 'success',
                'data'   => DriverResource::collection($drivers),
            ], 200);

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function store(DriverRequest $request)
    {
        try {

            $driver = Driver::create([
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
                'message'    => 'Successfully added driver...',
                'data'       => DriverResource::make($driver),
            ]);

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function update(DriverRequest $request, $id)
    {
        try {

            $driver = Driver::where('_id', $id)->where('company_id', auth()->user()->company_id)->first();

            if ($driver) {
                $driver->image   = request('image') ?? $driver->image;
                $driver->name    = request('name') ?? $driver->name;
                $driver->address = request('address') ?? $driver->address;
                $driver->phone   = request('phone') ?? $driver->phone;
                $driver->details = request('details') ?? $driver->details;
                $driver->docs    = request('docs') ?? $driver->docs;

                $driver->update();

                return response([
                    'status'     => 'success',
                    'statusCode' => 202,
                    'message'    => 'Successfully update driver...',
                    'data'       => DriverResource::make($driver),
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
            $driver = Driver::where('_id', $id)->where('company_id', auth()->user()->company_id)->first();

            if ($driver) {
                return response([
                    'status' => 'success',
                    'data'   => DriverResource::make($driver),
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
            $driver = Driver::where('_id', $id)->where('company_id', auth()->user()->company_id)->first();

            if ($driver) {
                $driver->delete();
                return response([
                    'status'  => 'success',
                    'message' => 'Driver deleted successfully',
                ], 202);
            } else {
                return itemNotFound();
            }

        } catch (Exception $e) {
            return serverError($e);
        }
    }
}