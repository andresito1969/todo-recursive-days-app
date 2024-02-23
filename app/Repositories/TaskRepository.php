<?php

namespace App\Repositories;
use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface {
    public function getTaskById($id) {
        return Task::findOrFail($id);
    }

    public function getAllTasksByUser($userId) {
        return Task::all()
                ->where('user_id', $userId);
    }
}
