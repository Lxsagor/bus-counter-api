<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistrictRequest;
use App\Http\Resources\DistrictResource;
use App\Models\District;
use Exception;

class DistrictController extends Controller
{
    public function index($divisionId)
    {
        try {
            $districts = DistrictResource::collection(District::where('division_id', $divisionId)->paginate())->response()->getData();

            return response([
                'status' => 'success',
                'data'   => $districts,
            ], 200);

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function store(DistrictRequest $request, $divisionId)
    {
        try {
            $district = District::create([
                'division_id' => $divisionId,
                'name'        => request('name'),
            ]);
            return response([
                'status'     => 'success',
                'statusCode' => 201,
                'message'    => 'Successfully added District..',
                'data'       => DistrictResource::make($district),
            ]);

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function show($divisionId, $id)
    {
        try {
            $district = District::where('_id', $id)->where('division_id', $divisionId)->first();
            if ($district) {
                return response([
                    'status' => 'success',
                    'data'   => DistrictResource::make($district),
                ], 200);
            } else {
                return itemNotFound();
            }

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function update(DistrictRequest $request, $divisionId, $id)
    {
        try {

            $district = District::where('_id', $id)->where('division_id', $divisionId)->first();
            if ($district) {
                return response([
                    'status'     => 'success',
                    'statusCode' => 202,
                    'message'    => 'Successfully updated..',
                    'data'       => DistrictResource::make($district),
                ]);
            } else {
                return itemNotFound();
            }

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function destroy($divisionId, $id)
    {
        try {
            $district = District::where('_id', $id)->where('division_id', $divisionId)->first();

            if ($district) {
                $district->delete();
                return response([
                    'status'  => 'success',
                    'message' => 'District deleted successfully',
                ], 200);
            } else {
                return itemNotFound();
            }

        } catch (Exception $e) {
            return serverError($e);
        }

    }
}
