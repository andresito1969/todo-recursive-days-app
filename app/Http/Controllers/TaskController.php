<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

use App\Http\Resources\TaskCollection;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facaes\Response;

use Exception;

class TaskController extends Controller
{
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository) {
        $this->taskRepository = $taskRepository;
    }

    public function getTasksByDay($userId, $day) {
        $taskList = $this->taskRepository->getAllTasksByUserAndDay($userId, $day);
        return new TaskCollection($taskList);
    }

    public function storeTaskByDay(Request $request, $userId, $day) {
        try {
            $request->validate([
                'text' => 'required',
                'completed' => 'required|boolean'
            ]);
            $requestData = $request->only('text', 'completed');
            $requestData["user_id"] = $userId;
            $requestData["task_date"] = $day;
            $this->taskRepository->storeTask($requestData);
            $succeedMessage = 'Task ' . $requestData['text'] . ' created!';
            return response()->json(['succeed' => $succeedMessage], 200);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'Te faltan rellenar campos   '
            ], 400);
        }
    }
    
    public function updateTaskById(Request $request, $user_id) {
        try {
            $request->validate([
                'text' => 'required',
                'completed' => 'required|boolean'
            ]);
            $requestData = $request->only('text', 'completed', 'id');
            $this->taskRepository->updateTask($requestData);
            $succeedMessage = 'Task ' . $requestData['id'] . ' updated!';
            return response()->json(['succeed' => $succeedMessage], 200);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'Te faltan rellenar campos   '
            ], 400);
        }  
    }

    public function deleteTaskById($user_id, $taskId) {
        try {
            $this->taskRepository->deleteTask($taskId);
            return response()->json(['succeed' => 'Task deleted'], 200);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'An exception has been caught.'
            ], 400);
        }
    }
}
