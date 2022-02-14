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
                $folder = request('folder') ?? 'all';
                $file   = request('file');
                // $fileType = explode('/', $file->getClientMimeType())[0];

                $fileName = $folder . "/" . time() . '.' . $file->getClientOriginalName();
                if (config('app.env') === 'production') {
                    $file->move('uploads/' . $folder, $fileName);
                } else {
                    $file->move(public_path('/uploads/' . $folder), $fileName);
                }

                $protocol = request()->secure() ? 'https://' : 'http://';

                return response([
                    'status'  => 'success',
                    'message' => 'File uploaded successfully',
                    'data'    => $protocol . $_SERVER['HTTP_HOST'] . '/uploads/' . $fileName,
                ], 200);
            }
        } catch (Exception $e) {
            return serverError($e);
        }
    }
}