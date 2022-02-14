<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FareRequest;
use App\Http\Resources\FareResource;
use App\Models\Fare;
use Illuminate\Http\Request;

class FareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $fares = FareResource::collection(Fare::with(['start_point', 'destination_point'])->paginate())->response()->getData();

            return response([
                "status" => "success",
                'data'   => $fares,
            ]);
        } catch (Exception $e) {
            return serverError($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FareRequest $request)
    {
        try {

            $fare = Fare::create([
                'company_id'              => auth()->user()->company_id,
                'starting_district_id'    => request('starting_district_id'),
                'destination_district_id' => request('destination_district_id'),
                'fare'                    => request('fare'),

            ]);
            return response([
                'status'     => 'success',
                'statusCode' => 201,
                'message'    => 'Successfully added fare...',
                'data'       => FareResource::make($fare->load('start_point', 'destination_point')),
            ]);

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $fare = Fare::where('_id', $id)->where('company_id', auth()->user()->company_id)->first();
            if ($fare) {
                return response([
                    'status' => 'success',
                    'data'   => FareResource::make($fare->load('start_point', 'destination_point')),
                ], 200);
            } else {
                return itemNotFound();
            }
        } catch (Exception $e) {
            return serverError($e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FareRequest $request, $id)
    {
        try {
            $fare = Fare::where('_id', $id)->where('company_id', auth()->user()->company_id)->first();
            if ($fare) {

                $fare->starting_district_id    = request('starting_district_id') ?? $fare->starting_district_id;
                $fare->destination_district_id = request('destination_district_id') ?? $fare->destination_district_id;
                $fare->fare                    = request('fare') ?? $fare->fare;
                $fare->update();
                return response([
                    'status'     => 'success',
                    'statusCode' => 202,
                    'message'    => 'Successfully update the fare...',
                    'data'       => FareResource::make($fare->load('start_point', 'destination_point')),
                ]);
            } else {
                return itemNotFound();
            }

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $fare = Fare::where('_id', $id)->where('company_id', auth()->user()->company_id)->first();

            if ($fare) {
                $fare->delete();
                return response([
                    'status'  => 'success',
                    'message' => 'Fare deleted successfully',
                ], 200);
            } else {
                return itemNotFound();
            }

        } catch (Exception $e) {
            return serverError($e);
        }
    }
}