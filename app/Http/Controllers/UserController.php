<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\UserCollection;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\ValidationException;
use Illuminate\Database\UniqueConstraintViolationException;

use JWTAuth;
use Exception;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function login(Request $request) {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
        } catch(Exception $e) {
            return response()->json([
                'error' => "Te faltan datos por rellenar"
            ], 401);
        }
        
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        if(!$token) {
            return response()->json([
                'error' => 'Parece que el mail o la contraseña no son válidos'
            ], 401);
        }

        $user = JWTAuth::user();
        return response()->json([
            'token' => $token,
            'token type' => 'Bearer',
            'full_token' => 'Bearer ' . $token,
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ]);
    }

    private function registerApiErrorHandler($credentials) : void{
        if(strlen($credentials['email']) > 25) {
            throw new Exception('El email no puede contener más de 25 caracteres.');
        } 
        if(strlen($credentials['name']) < 3 || strlen($credentials['name']) > 15) {
            throw new Exception('El nombre tiene que ser entre 3 y 15 caracteres.');
        } 
        if(strlen($credentials['password']) < 5 || strlen($credentials['password']) > 20) {
            throw new Exception('La contraseña tiene que ser entre 5 y 20 caracteres.');
        }
    }

    public function register(Request $request) {
        try {
            $request->validate([
                'email' => 'required|email',
                'name' => 'required',
                'password' => 'required'
            ]);
            $credentials = $request->only('email', 'name', 'password');

            $this->registerApiErrorHandler($credentials);
            
            $this->userRepository->storeUser($credentials);
            $succeedMessage = 'User ' . $credentials['email'] . ' created!';
            return response()->json(['succeed' => $succeedMessage], 200);
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            if($e instanceof ValidationException){
                $errorMessage = "Te faltan datos por rellenar";
            } else if($e instanceof UniqueConstraintViolationException) {
                $errorMessage = "El email ya está en uso";
            }
            return response()->json([
                'error' => $errorMessage
            ], 400);
        }
    }
}
