<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusRequest;
use App\Http\Resources\BusResource;
use App\Models\Bus;
use Exception;

class BusController extends Controller
{
    public function index()
    {
        try {
            $buses = BusResource::collection(Bus::paginate())->response()->getData();
            return response([
                'status' => 'success',
                'data'   => $buses,
            ], 200);
        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function store(BusRequest $request)
    {
        try {

            $bus = Bus::create([
                'company_id' => auth()->user()->company_id,
                'bus_no'     => request('bus_no'),
                'bus_reg_no' => request('bus_reg_no'),
                'chesis_no'  => request('chesis_no'),
                'bus_type'   => request('bus_type'),
                'total_seat' => request('total_seat'),
            ]);
            return response([
                'status'     => 'success',
                'statusCode' => 201,
                'message'    => 'Successfully added bus...',
                'data'       => BusResource::make($bus),
            ]);

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function update(BusRequest $request, $id)
    {
        try {

            $bus = Bus::where('_id', $id)->where('company_id', auth()->user()->company_id)->first();
            if ($bus) {
                $bus->bus_no     = request('bus_no') ?? $bus->bus_no;
                $bus->bus_reg_no = request('bus_reg_no') ?? $bus->bus_reg_no;
                $bus->chesis_no  = request('chesis_no') ?? $bus->chesis_no;
                $bus->bus_type   = request('bus_type') ?? $bus->bus_type;
                $bus->total_seat = request('total_seat') ?? $bus->total_seat;

                $bus->update();
                return response([
                    'status'     => 'success',
                    'statusCode' => 202,
                    'message'    => 'Successfully update bus...',
                    'data'       => BusResource::make($bus),
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

            $bus = Bus::where('_id', $id)->where('company_id', auth()->user()->company_id)->first();

            if ($bus) {

                return response([
                    'status' => 'success',
                    'data'   => BusResource::make($bus),
                ], 200);

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
            $bus = Bus::where('_id', $id)->where('company_id', auth()->user()->company_id)->first();
            if ($bus) {
                $bus->delete();
                return response([
                    'status'  => 'success',
                    'message' => 'Bus deleted successfully',

                ], 200);
            } else {
                return itemNotFound();
            }

        } catch (Exception $e) {
            return serverError($e);
        }
    }
    public function get()
    {
        try {
            $buses = Bus::get();
            return response([
                'status' => 'success',
                'data'   => BusResource::collection($buses),
            ], 200);
        } catch (Exception $e) {
            return serverError($e);
        }
    }
    public function getBusByType($type)
    {
        try {
            $buses = Bus::where('bus_type', $type)->get();
            return response([
                'status' => 'success',
                'data'   => BusResource::collection($buses),
            ], 200);
        } catch (Exception $e) {
            return serverError($e);
        }
    }
}