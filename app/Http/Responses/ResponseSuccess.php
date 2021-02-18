<?php


namespace App\Http\Responses;


class ResponseSuccess extends ApiResponse
{
    public function __construct($response = [],$message='Thành công'){
        $this->code = 200;
        $this->success=true;
        $this->message = $message;
        $this->response = $response;
    }
}
