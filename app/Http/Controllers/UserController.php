<?php
namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function create(Request $request){
        $this->validate($request,[
            'email'=>'required|unique:Users|email',
            'password'=>'required',
            'full_name'=>'required'
        ],[
            'required'=>':attribute không được để trống',
            'unique'=>':attribute đã tồn tại',
        ]);
        $create = $this->userService->create($request);
        return response()->json($create->toArray());
    }
    public function login(){
        $login = $this->userService->login();
        return response()->json($login->toArray());
    }
    public function logout(){
        $logout = $this->userService->logout();
        return response()->json($logout->toArray());
    }
}