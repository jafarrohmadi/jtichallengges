<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;

class BaseController extends Controller
{
    /**
     * @param $data
     * @return ResponseFactory|Response
     */
    public function returnSuccess($data)
    {
        $response = [
            'status'  => true,
            'message' => 'Success',
            'data'    => $data,
        ];

        return response($response, 200);
    }

    /**
     * @param  string  $message
     * @param  string|array  $data
     * @return ResponseFactory|Response
     */
    public function returnFalse(
        string $message = 'failed',
        $data = 'No Data Found'
    ) {
        $response = [
            'status'  => false,
            'message' => $message,
            'data'    => $data,
        ];

        return response($response, 200);
    }
}
