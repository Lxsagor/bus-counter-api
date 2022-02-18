<?php

namespace App\Http\Controllers\Api\Counter;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Exception;

class BookingController extends Controller
{
    public function track()
    {
        try {

            $tracks = Track::whereIn('route', [request('start_location'), request('end_location')])->get();

            return response([
                'status' => 'success',
                'data'   => $tracks,
            ]);
        } catch (Exception $e) {
            return serverError($e);
        }
    }
}