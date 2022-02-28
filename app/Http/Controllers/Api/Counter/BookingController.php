<?php

namespace App\Http\Controllers\Api\Counter;

use App\Http\Controllers\Controller;
use App\Http\Requests\CounterManager\AssignBusRequest;
use App\Http\Resources\CounterManager\AssignBusResource;
use App\Http\Resources\ScheduleBusResource;
use App\Models\CounterManager\AssignBus;
use App\Models\ScheduleBus;
use Exception;

class BookingController extends Controller
{
    public function allRoutes()
    {
        try {

            $scheduleBuses = ScheduleBus::with(['assign_buses'])->get();
            // dd($scheduleBuses);
            return response([
                'status' => 'success',
                // 'data'   => $scheduleBuses,
                'data'   => ScheduleBusResource::collection($scheduleBuses),
            ], 200);

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function routeSearch()
    {
        try {

            $scheduleBuses = ScheduleBus::whereIn('routes_id', [request('start_location'), request('end_location')])->get();

            return response([
                'status' => 'success',
                'data'   => ScheduleBusResource::collection($scheduleBuses),
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
                'route_id'   => request('route_id'),
                'bus_no'     => request('bus_no'),
                'bus_type'   => request('bus_type'),
                'driver_id'  => request('driver_id'),
                'staff_id'   => request('staff_id'),
                'time'       => request('time'),

                // 'supervisor' => request('supervisor'),
                // 'journey_start_id' => request('journey_start_id'),
                // 'journey_end_id'   => request('journey_end_id'),

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