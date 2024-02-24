<?php

namespace App\Repositories;
use App\Models\Task;
use DateTime;


class TaskRepository implements TaskRepositoryInterface {
    public function getTaskById($id) {
        return Task::findOrFail($id);
    }

    public function getAllTasksByUser($userId) {
        return Task::all()
                ->where('user_id', $userId);
    }

    public function getAllTasksByUserAndDay($userId, $date) {

        // with this logic we can check if the {$date} is less than tomorrow
        // and if the date is greater or equal than today
        // why we do it like that? Because if we try to check between startDate with hours 00:00:00 and endDate 23:59:59 we can lose data within 1 second of margin
        
        // php ways of checking dates from string into DB things pse :D .......
        $toX = strtotime($date . ' + 1 day');
        $fromX = strtotime($date);
        $dateTo = date('Y-m-d 00:00:00', $toX);
        $dateFrom = date('Y-m-d 00:00:00', $fromX);
        
        return Task::where('user_id', $userId)
                ->where('task_date', '>=', $dateFrom)
                ->where('task_date', '<', $dateTo)
                ->get();
    }

    public function storeTask(array $data) : void {
        $task = new Task($data);
        $task->save();
    }

    public function updateTask(array $data) : void {
        $task = $this->getTaskById($data["id"]);
        $task->update($data);
    }

    public function deleteTask($taskId) : void {
        $task = $this->getTaskById($taskId);
        $task->delete();
    }
}
