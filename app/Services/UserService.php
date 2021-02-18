<?php

namespace App\Services;

use App\Http\Responses\StatusCode;
use Illuminate\Support\Facades\Auth;
use App\Http\Responses\ResponseError;
use App\Http\Responses\ResponseSuccess;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;


class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create($request)
    {
        $create = $this->userRepository->create([
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            //hoac md5
            'full_name' => $request->get('full_name'),
        ]);
        return (new ResponseSuccess($create, 'Tạo tài khoản thành công!'));
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = Auth::attempt($credentials)) {
            return (new ResponseError(StatusCode::BAD_REQUEST, 'Email hoac password khong dung!'));
        }

        return (new ResponseSuccess(['token' => $token], 'Dang nhap thanh cong!'));
    }

    public function logout()
    {
        Auth::logout();
        return (new ResponseSuccess(StatusCode::SUCCESS, 'Dang xuat thanh cong'));
    }
}