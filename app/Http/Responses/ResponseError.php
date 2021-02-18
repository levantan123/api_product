<?php


namespace App\Http\Responses;


class ResponseError extends ApiResponse
{
    public function __construct($status=500,$message='Thành công'){
        $this->code = $status;
        $this->success=false;
        $this->message = $message;
        $this->response = [];
    }
}
