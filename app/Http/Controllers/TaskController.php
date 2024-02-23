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


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository) {
        $this->taskRepository = $taskRepository;
    }

    // In order to call this index method (get), we should pass query params (api/tasks?user_id=x)
    public function index(Request $request)
    {
        $userId = $request->query('user_id');
        $taskList = $this->taskRepository->getAllTasksByUser($userId);
        
        return new TaskCollection($taskList);
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
    public function store(StoreTaskRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->taskRepository->getTaskById($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
