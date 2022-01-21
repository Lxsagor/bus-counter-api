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

    public function store(ScheduleBusRequest $request)
    {
        try {
            $scheduleBus = ScheduleBus::create([
                'bus_id'        => request('bus_id'),
                'bus_no'        => request('bus_no'),
                'start_counter' => request('start_counter'),
                'end_counter'   => request('end_counter'),
                'mid_counters'  => request('mid_counters'),
                'date'          => request('date'),
                'time'          => request('time'),

            ]);
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

                $scheduleBus->bus_id        = request('bus_id') ?? $scheduleBus->bus_id;
                $scheduleBus->bus_no        = request('bus_no') ?? $scheduleBus->bus_no;
                $scheduleBus->start_counter = request('start_counter') ?? $scheduleBus->start_counter;
                $scheduleBus->end_counter   = request('end_counter') ?? $scheduleBus->end_counter;
                $scheduleBus->mid_counters  = request('mid_counters') ?? $scheduleBus->mid_counters;
                $scheduleBus->date          = request('date') ?? $scheduleBus->date;
                $scheduleBus->time          = request('time') ?? $scheduleBus->time;

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
}
