<?php

namespace App\Repositories;

interface TaskRepositoryInterface{
    public function getTaskById($id);

    public function getAllTasksByUser($userId);

    public function getAllTasksByUserAndDay($userId, $date);

    public function storeTask(array $data) : void;

    public function updateTask(array $data, $taskId) : void;
    
    public function deleteTask($taskId) : void;
}