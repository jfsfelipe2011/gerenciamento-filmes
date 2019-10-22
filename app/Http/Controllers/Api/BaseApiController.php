<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseApiController extends Controller
{
    private $responseStatus = [
        'status' => [
            'isSuccess' => true,
            'statusCode' => 200,
            'message' => '',
        ]
    ];

    // Setter method for the response status
    public function setResponseStatus(bool $isSuccess = true, int $statusCode = 200, string $message = '')
    {
        $this->responseStatus['status']['isSuccess'] = $isSuccess;
        $this->responseStatus['status']['statusCode'] = $statusCode;
        $this->responseStatus['status']['message'] = $message;
    }

    // Returns the response with only status key
    public function sendResponseStatus($isSuccess = true, $statusCode = 200, $message = '')
    {

        $this->responseStatus['status']['isSuccess'] = $isSuccess;
        $this->responseStatus['status']['statusCode'] = $statusCode;
        $this->responseStatus['status']['message'] = $message;

        $json = $this->responseStatus;

        return response()->json($json, $this->responseStatus['status']['statusCode']);

    }

    // If you have additional data to send in the response
    public function sendResponseData($data)
    {

        $tdata = $this->dataTransformer($data);

        if(!empty($this->meta)) $tdata['meta'] = $this->meta;

        $json = [
            'status' => $this->responseStatus['status'],
            'data' => $tdata,
        ];


        return response()->json($json, $this->responseStatus['status']['statusCode']);

    }

    /**
     * @param $erros
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendErrors($errors)
    {
        $responseCode = 422;

        $headers = array (
            'Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'
        );

        return response()->json($errors, $responseCode, $headers, JSON_UNESCAPED_UNICODE);
    }
}
