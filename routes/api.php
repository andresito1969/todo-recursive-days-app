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

Route::group(['middleware' => ['JWTAuth']], function() {
    // Route::apiResource('users', UserController::class);
    // Route::apiResource('tasks', TaskController::class);
    
    Route::get('{user_id}/task/{day}', [TaskController::class, 'getTasksByDay']);
    Route::post('{user_id}/task/{day}', [TaskController::class, 'storeTaskByDay']);
    Route::patch('{user_id}/task', [TaskController::class, 'updateTaskById']);
    Route::delete('{user_id}/task/{task_id}', [TaskController::class, 'deleteTaskById']);
});


Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
