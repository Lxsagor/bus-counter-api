<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrackRequest;
use App\Http\Resources\TrackResource;
use App\Models\Track;
use Exception;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $tracks = TrackResource::collection(Track::paginate())->response()->getData();
            return response([
                'status' => 'success',
                'data'   => $tracks,
            ], 200);

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

    public function store(TrackRequest $request)
    {

        try {
            $track = Track::create([
                'company_id' => auth()->user()->company_id,
                'route'      => request('route'),
                'bus_type'   => request('bus_type'),
                'day_time'   => request('day_time'),

            ]);
            return response([
                'status'     => 'success',
                'statusCode' => 201,
                'message'    => 'Successfully added the Track',
                'data'       => TrackResource::make($track),
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
            $track = Track::where('_id', $id)->where('company_id', auth()->user()->company_id)->first();
            if ($track) {
                return response([
                    'status' => 'success',
                    'data'   => TrackResource::make($track),
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
    public function update(TrackRequest $request, $id)
    {
        try {
            $track = Track::where('_id', $id)->where('company_id', auth()->user()->company_id)->first();
            if ($track) {

                $track->route    = request('route') ?? $track->route;
                $track->bus_type = request('bus_type') ?? $track->bus_type;
                $track->day_time = request('day_time') ?? $track->day_time;

                $track->update();
                return response([
                    'status'     => 'success',
                    'statusCode' => 202,
                    'message'    => 'Successfully update the track...',
                    'data'       => TrackResource::make($track),
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
            $track = Track::where('_id', $id)->where('company_id', auth()->user()->company_id)->first();

            if ($track) {
                $track->delete();
                return response([
                    'status'  => 'success',
                    'message' => 'Track deleted successfully',
                ], 200);
            } else {
                return itemNotFound();
            }

        } catch (Exception $e) {
            return serverError($e);
        }
    }
}