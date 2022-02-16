<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
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
        //
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
                'type'       => request('type'),

            ]);
            if ($track && request()->has('day_time')) {
                foreach (request('day_time') as $dayTime) {
                    $data = array_merge($track, $dayTime);

                }

            }
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
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}