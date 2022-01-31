<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // public static function sendResponse($validator){
    //     if ($validator->fails()) {

    //         $data = [
    //             'error' => [
    //                 'code' => 422,
    //                 'message' => 'Validation Error',
    //                 'errors' => $validator->errors()
    //             ]
    //         ];

    //         return response()->json($data, 422);
    //     }
    // }
}
