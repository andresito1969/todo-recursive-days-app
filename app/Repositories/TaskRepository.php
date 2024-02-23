<?php

namespace App\Repositories;
use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface {
    public function getTaskById($id) {
        return Task::findOrFail($id);
    }

    public function getAllTasks() {
        return Task::all();
    }
}
