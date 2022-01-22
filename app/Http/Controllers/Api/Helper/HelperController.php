<?php

namespace App\Http\Controllers\Api\Helper;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function fileUploader(Request $request)
    {

        try {
            if (request()->has('file')) {
                $folder    = $request->folder ?? 'all';
                $image     = $request->file('file');
                $imageName = $folder . "/" . time() . '.' . $image->getClientOriginalName();
                $image->move(public_path('/uploads/' . $folder), $imageName);
                $protocol = request()->secure();
                return response([
                    'status'  => 'success',
                    'message' => 'File uploaded successfully',
                    'data'    => $protocol ? 'https://' : 'http://' . $_SERVER['HTTP_HOST'] . '/uploads/' . $imageName,
                ], 200);
            }
        } catch (Exception $e) {
            return serverError($e);
        }
    }
}
