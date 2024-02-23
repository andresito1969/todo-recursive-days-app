<?php

namespace App\Repositories;

interface TaskRepositoryInterface{
    public function getTaskById($id);

    public function getAllTasksByUser($userId);

}