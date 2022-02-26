<?php

namespace App\Http\Controllers\Api\Counter;

use App\Http\Controllers\Controller;
use App\Http\Requests\CounterManager\AssignBusRequest;
use App\Http\Resources\CounterManager\AssignBusResource;
use App\Http\Resources\TrackResource;
use App\Models\CounterManager\AssignBus;
use App\Models\Track;
use Exception;

class BookingController extends Controller
{
    public function allRoutes()
    {
        try {

            $tracks = Track::get();
            return response([
                'status' => 'success',
                'data'   => TrackResource::collection($tracks->load('assign_buses.bus_by_no')),

            ], 200);

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function routeSearch()
    {
        try {

            $tracks = Track::whereIn('route', [request('start_location'), request('end_location')])->get();

            return response([
                'status' => 'success',
                'data'   => TrackResource::collection($tracks->load('assign_bus')),
            ]);
        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function assignBus(AssignBusRequest $request)
    {
        try {
            $assign = AssignBus::create([
                'counter_id' => auth()->user()->counter_id,
                'track_id'   => request('track_id'),
                'bus_no'     => request('bus_no'),
                'bus_type'   => request('bus_type'),
                'driver_id'  => request('driver_id'),
                'staff_id'   => request('staff_id'),
                'supervisor' => request('supervisor'),
                // 'journey_start_id' => request('journey_start_id'),
                // 'journey_end_id'   => request('journey_end_id'),
                // 'date_time'        => request('date_time'),

            ]);
            return response([
                'status'     => 'success',
                'statusCode' => 201,
                'message'    => 'Successfully Assigned Bus...',
                'data'       => AssignBusResource::make($assign->load('bus_by_no', 'driver', 'staff')),
            ]);

        } catch (Exception $e) {
            return serverError($e);
        }
    }

}