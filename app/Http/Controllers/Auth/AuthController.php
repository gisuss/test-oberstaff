<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Services\Auth\AuthService;

class AuthController extends Controller
{
    private AuthService $service;

    public function __construct(AuthService $service) {
        $this->service = $service;
    }

    /**
     * Login User
     */
    public function login(Request $request) {
        $result = $this->service->login($request);
        return response()->json($result);
    }

    /**
     * Logout an User
     */
    public function logout() {
        $result = $this->service->logout();
        return response()->json($result);
    }
}
