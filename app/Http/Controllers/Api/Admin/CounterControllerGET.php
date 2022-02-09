<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CounterRequest;
use App\Http\Resources\CounterResource;
use App\Models\Counter;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CounterControllerGET extends Controller
{
    public function index()
    {
        try {
            $counters = Counter::get();

            return response([
                "status" => "success",
                'data'   => CounterResource::collection($counters),
            ]);

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function store(CounterRequest $request)
    {
        try {
            // dd(User::COUNTER_MANAGER);

            $counter = Counter::create([
                'company_id'  => auth()->user()->company_id,
                'division_id' => request('division_id'),
                'district_id' => request('district_id'),
                'name'        => request('name'),
                // 'go_through'  => request('go_through'),

            ]);
            if ($counter) {
                $data = [
                    'counter_id' => $counter->id,
                    'role_id'    => User::COUNTER_MANAGER,
                    'name'       => request('manager_name'),
                    'phone'      => request('phone'),
                    'password'   => Hash::make(request('password')),
                ];

                User::create($data);

                return response([
                    'status'     => 'success',
                    'statusCode' => 201,
                    'message'    => 'Counter create successfully',
                    'data'       => CounterResource::make($counter->load('counter_managers')),
                    // 'data'       => CounterResource::make($counter->load('counter_managers')),
                ]);
            }

        } catch (Exception $e) {
            // dd($e);
            return serverError($e);
        }
    }

    public function update($id)
    {
        // dd(auth()->user()->company_id);

        try {

            $counter = Counter::where('_id', $id)->where('company_id', auth()->user()->company_id)->first();
            // dd($counter);
            if ($counter) {
                $counter->name        = request('name') ?? $counter->name;
                $counter->division_id = request('division_id') ?? $counter->division_id;
                $counter->district_id = request('district_id') ?? $counter->district_id;
                // $counter->go_through  = request('go_through') ?? $counter->go_through;

                $counter->update();

                return response([
                    'status'     => 'success',
                    'statusCode' => 202,
                    'message'    => 'Successfully update counter...',
                    'data'       => CounterResource::make($counter),
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
            $counter = Counter::where('_id', $id)->where('company_id', auth()->user()->company_id)->first();
            if ($counter) {
                return response([
                    'status' => 'success',
                    'data'   => CounterResource::make($counter),
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
            $counter = Counter::where('_id', $id)->where('company_id', auth()->user()->company_id)->first();

            if ($counter) {
                $counter->delete();
                return response([
                    'status'  => 'success',
                    'message' => 'Counter deleted successfully',
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

            $counters = Counter::query();

            if (request()->has('division_id')) {
                $counters = $counters->where('division_id', request('division_id'));
            }

            if (request()->has('district_id') && request('district_id') !== null) {
                $counters = $counters->where('district_id', request('district_id'));
            }

            $counters = CounterResource::collection($counters->with(['district', 'division', 'counter_managers'])->paginate())->response()->getData();

            // if ($counters) {
            //     return $counters;
            // } else {
            //     $counters = Counter::paginate();
            // }
            return response([
                'status' => 'success',
                'data'   => $counters,
            ], 200);

        } catch (Exception $e) {
            return serverError($e);
        }
    }
}