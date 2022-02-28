<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleBusRequest;
use App\Http\Resources\ScheduleBusResource;
use App\Models\ScheduleBus;
use Exception;

class ScheduleBusController extends Controller
{
    public function index()
    {
        try {

            $scheduleBuses = ScheduleBusResource::collection(ScheduleBus::paginate())->response()->getData();
            return response([
                'status' => 'success',
                'data'   => $scheduleBuses,
            ], 200);

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function get()
    {
        try {

            $scheduleBuses = ScheduleBus::get();
            return response([
                'status' => 'success',
                'data'   => ScheduleBusResource::collection($scheduleBuses),
            ], 200);

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function store(ScheduleBusRequest $request)
    {
        try {
            $scheduleBus = ScheduleBus::create([
                'bus_type'      => request('bus_type'),
                'bus_seat_type' => request('bus_seat_type'),
                // 'start_counter_id' => request('start_counter_id'),
                // 'end_counter_id'   => request('end_counter_id'),
                'routes_id'     => request('routes_id'),
                'day_time'      => request('day_time'),
                'fares'         => request('fares'),

            ]);
            // if ($scheduleBus && request()->has('fares')) {
            //     foreach (request('fares') as $fare) {
            //         $data = array_merge($fare, ['schedule_bus_id' => $scheduleBus->id]);
            //         Fare::create($data);
            //     }

            // }
            return response([
                'status'     => 'success',
                'statusCode' => 201,
                'message'    => 'Successfully added the schedule of the bus...',
                'data'       => ScheduleBusResource::make($scheduleBus),
            ]);
        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function update(ScheduleBusRequest $request, $id)
    {
        try {

            $scheduleBus = ScheduleBus::where('_id', $id)->first();

            if ($scheduleBus) {

                $scheduleBus->bus_type      = request('bus_type') ?? $scheduleBus->bus_type;
                $scheduleBus->bus_seat_type = request('bus_seat_type') ?? $scheduleBus->bus_seat_type;
                $scheduleBus->routes_id     = request('routes_id') ?? $scheduleBus->routes_id;
                $scheduleBus->day           = request('day') ?? $scheduleBus->day;
                $scheduleBus->time          = request('time') ?? $scheduleBus->time;
                $scheduleBus->fares         = request('fares') ?? $scheduleBus->fares;
                // $scheduleBus->time          = request('time') ?? $scheduleBus->time;

                $scheduleBus->update();

                return response([
                    'status'     => 'success',
                    'statusCode' => 202,
                    'message'    => 'Successfully update schedule...',
                    'data'       => ScheduleBusResource::make($scheduleBus),
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

            $scheduleBus = ScheduleBus::where('_id', $id)->first();

            if ($scheduleBus) {
                return response([
                    'status' => 'success',
                    'data'   => ScheduleBusResource::make($scheduleBus),
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

            $scheduleBus = ScheduleBus::where('_id', $id)->first();

            if ($scheduleBus) {

                $scheduleBus->delete();

                return response([
                    'status'  => 'success',
                    'message' => 'Schedule  deleted successfully',
                ], 200);

            } else {
                return itemNotFound();
            }

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function search()
    {
        try {
            $data          = request('keyword');
            $scheduleBuses = null;

            if ($data) {
                $scheduleBuses = ScheduleBus::where('date_time', 'like', "%{$data}%")
                    ->paginate();
            } else {
                $scheduleBuses = ScheduleBus::paginate();
            }

            return response([
                'status' => 'success',
                'data'   => ScheduleBusResource::collection(ScheduleBus::with(['bus_by_no', 'start_counter', 'end_counter', 'fares'])->paginate())->response()->getData(),
            ], 200);

        } catch (Exception $e) {
            return serverError($e);
        }
    }

}