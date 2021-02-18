<?php


namespace App\Http\Responses;


abstract class ApiResponse implements CanRespond
{
    protected $code;
    protected $message;
    protected $success;
    protected $response;

    public function toArray()
    {
        return [
            'status' => $this->code,
            'content' => $this->message,
            'success'=>$this->success,
            'data'=>(object)$this->response
        ];
    }
}
