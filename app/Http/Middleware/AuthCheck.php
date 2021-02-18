<?php

namespace App\Http\Middleware;

use App\Http\Responses\ResponseError;
use App\Http\Responses\StatusCode;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthCheck
{

    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            return $next($request);
        }
        return response()->json((new ResponseError(StatusCode::UNAUTHORIZED,'Ban can dang nhap!'))->toArray());
    }
}
