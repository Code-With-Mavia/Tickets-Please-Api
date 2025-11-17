<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponses;
use App\Http\Requests\ApiLoginRequest;
use App\Http\Requests\ApiRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    use ApiResponses;

    // Login
    public function login(ApiLoginRequest $request)
    {
        $user = $request->only('email', 'password');

        if (!$token = auth()->attempt($user))
        {
            return $this->error('Invalid credentials', 401);
        }

        return $this->ok([
            'token' => $token,
            'user' => auth()->user(),
        ], 'Login successful');
    }

    // Registration
    public function registration(ApiRegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return $this->ok($user, 'User registered successfully');
    }


}
