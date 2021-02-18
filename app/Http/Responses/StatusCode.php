<?php


namespace App\Http\Responses;


class StatusCode
{
    const SUCCESS = 200;
    const ERROR = 500;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const UNAUTHORIZED = 401;
    const NO_CONTENT = 204;
    const BAD_REQUEST = 400;
    const UNPROCESSABLE_ENTITY = 422; //lỗi xác thực đầu vào

}
