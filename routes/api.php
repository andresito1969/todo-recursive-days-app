<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['JWTAuth'], 'prefix' => '{user_id}'], function() {
    Route::get('/task/{day}', [TaskController::class, 'getTasksByDay']);
    Route::post('/task/{day}', [TaskController::class, 'storeTaskByDay']);
    Route::patch('/task', [TaskController::class, 'updateTaskById']);
    Route::delete('/task/{task_id}', [TaskController::class, 'deleteTaskById']);
});


Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
