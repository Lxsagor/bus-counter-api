<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DivisionRequest;
use App\Http\Resources\DivisionResource;
use App\Models\Division;
use Exception;

class DivisionController extends Controller
{
    public function index()
    {
        try {
            $divisions = Division::get();
            return response([
                'status' => 'success',
                'data'   => DivisionResource::collection($divisions),
            ], 200);

        } catch (Exception $e) {
            return serverError($e);
        }
    }
    public function store(DivisionRequest $request)
    {
        try {
            $division = Division::create([
                'name' => request('name'),
            ]);
            return response([
                'status'     => 'success',
                'statusCode' => 201,
                'message'    => 'Successfully division added',
                'data'       => DivisionResource::make($division),
            ]);

        } catch (Exception $e) {
            return serverError($e);
        }
    }
    public function show($id)
    {
        try {

            $division = Division::where('_id', $id)->first();
            if ($division) {
                return response([
                    'status' => 'success',
                    'data'   => DivisionResource::make($division),
                ], 200);
            } else {
                return itemNotFound();
            }

        } catch (Exception $e) {
            return serverError($e);
        }
    }
    public function update(DivisionRequest $request, $id)
    {
        try {
            $division = Division::where('_id', $id)->first();
            if ($division) {
                return response([
                    'status'     => 'success',
                    'statusCode' => 202,
                    'message'    => 'Successfully updated..',
                    'data'       => DivisionResource::make($division),
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

            $division = Division::where('_id', $id)->first();
            if ($division) {
                $division->delete();
                return response([
                    'status'  => 'success',
                    'message' => 'Division deleted successfully',
                ], 200);
            } else {
                return itemNotFound();
            }

        } catch (Exception $e) {
            return serverError($e);
        }
    }
}