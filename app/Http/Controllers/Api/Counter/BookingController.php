<?php

namespace App\Http\Controllers\Api\Counter;

use App\Http\Controllers\Controller;
use App\Http\Requests\CounterManager\AssignBusRequest;
use App\Http\Requests\CounterManager\BookingRequest;
use App\Http\Resources\CounterManager\AssignBusResource;
use App\Http\Resources\CounterManager\TicketBookResource;
use App\Http\Resources\ScheduleBusResource;
use App\Models\CounterManager\AssignBus;
use App\Models\CounterManager\TicketBook;
use App\Models\ScheduleBus;
use Carbon\Carbon;
use Exception;

class BookingController extends Controller
{
    public function allRoutes()
    {
        try {

            $scheduleBuses = ScheduleBus::with(['assign_buses.bus_by_no'])->get();
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
            $day = Carbon::parse(request('journey_date'))->englishDayOfWeek;

            $scheduleBuses = ScheduleBus::with([
                'assign_buses'              => function ($query) {
                    $query->where('date', Carbon::parse(request('journey_date')));
                },
                'assign_buses.bus_by_no',
                'assign_buses.ticket_books' => function ($query) {
                    $query->where('status', 'active');
                },
            ])
                ->whereIn('routes_id', [request('start_location')])
                ->whereIn('routes_id', [request('end_location')])
                ->get();

            $routes = [];

            if (count($scheduleBuses) > 0) {
                foreach ($scheduleBuses as $item) {
                    foreach ($item->day_time as $dayTime) {
                        if ($dayTime['day'] === strtolower($day)) {
                            $routes[] = $item;
                        }
                    }
                }
            }

            return response([
                'status' => 'success',
                'data'   => ScheduleBusResource::collection($routes),
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
                'date'       => request('date'),

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

    public function ticketBooking(BookingRequest $request)
    {
        try {

            $ticketBooking = TicketBook::create([
                'counter_id'   => auth()->user()->counter_id,
                'seat_no'      => request('seat_no'),
                'fare'         => request('fare'),
                'name'         => request('name'),
                'phone'        => request('phone'),
                'coach_id'     => request('coach_id'),
                'route_id'     => request('route_id'),
                'journey_time' => request('journey_time'),
                'PNR'          => "DTR" . "-" . mt_rand(100000000, 999999999),
                'status'       => "active",
            ]);

            return response([
                'status'  => 'success',
                'message' => 'Ticket booked successfully',
                'data'    => TicketBookResource::make($ticketBooking->load('assign_bus', 'schedule_bus')),
                // 'data'    => TicketBookResource::make($ticketBooking),
            ]);

        } catch (Exception $e) {
            return serverError($e);
        }
    }
    public function searchTicket()
    {
        try {
            $ticket = TicketBook::with(['schedule_bus', 'assign_bus.bus_by_no', 'assign_bus.ticket_books'])->where('PNR', request('pnr'))->where('status', "active")->first();

            if ($ticket) {
                return response([
                    'status'     => 'success',
                    'statusCode' => 200,
                    'data'       => TicketBookResource::make($ticket),
                ]);
            } else {
                return itemNotFound();
            }
        } catch (Exception $e) {
            return serverError($e);
        }
    }
    public function cancelTicket()
    {
        try {
            $ticket = TicketBook::where('PNR', request('pnr'))->where('status', "active")->first();
            if ($ticket) {
                $ticket->status = 'cancel';
                $ticket->update();
                return response([
                    'status'  => 'success',
                    'message' => 'Ticket canceled successfully',
                    // 'data'    => TicketBookResource::make($ticket),
                ]);

            } else {
                return itemNotFound();
            }
        } catch (Exception $e) {
            return serverError($e);
        }
    }

}