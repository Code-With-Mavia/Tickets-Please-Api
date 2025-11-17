<?php

namespace App\Http\Controllers;
use App\Traits\ApiResponses;
use App\Http\Requests\ApiLoginRequest;
use App\Models\User;

class AuthController extends Controller
{
    use ApiResponses;
    public function login(ApiLoginRequest $request)
    {
        return $this->ok($request->get("email"));
    }
    // public function register(ApiLoginRequest $request)
    // {
    //     return $this->ok($request->post("email"));
    // }
    // user registration
    public function registration( ApiLoginRequest $request)
    {
        $user = User::create($request->all());
        return $user;
    }

}
