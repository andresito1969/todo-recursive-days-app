<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\UserCollection;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

use JWTAuth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $userList = $this->userRepository->getAllUsers();

        return new UserCollection($userList);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->userRepository->getUserById($id);
        // return new UserCollection($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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

        $credentials = $request->only('email', 'name', 'password');
        $isRegisteredUser = $this->userRepository->getUserByMail($credentials['email']);

        if($isRegisteredUser) {
            return response()->json(['error' => 'Mail already in use'], 409);
        } else {
            $this->userRepository->storeUser($credentials);
            $succeedMessage = 'User ' . $credentials['email'] . ' created!';
            return response()->json(['succeed' => $succeedMessage], 200);
        }
    }
}
