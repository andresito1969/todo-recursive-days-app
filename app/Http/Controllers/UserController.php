<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\UserCollection;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

use JWTAuth;
use Exception;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        
        if(!$token) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request) {
        try {
            $request->validate([
                'email' => 'required|email|unique:users,email'
            ]);
            $credentials = $request->only('email', 'name', 'password');
            $this->userRepository->storeUser($credentials);
            $succeedMessage = 'User ' . $credentials['email'] . ' created!';
            return response()->json(['succeed' => $succeedMessage], 200);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'Format del mail inválido o ya en uso'
            ], 400);
        }
    }
}
