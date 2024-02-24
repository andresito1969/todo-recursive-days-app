<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;

class TaskTest extends TestCase
{

    private function getUserTestInfo() {
        $user = $this->post('/api/login', [
            'email' => 'andres@dev.com',
            'password' => 'test123'
        ]);

        return json_decode($user->getContent());
    }
    /*
     * GET endpoint
     */

    public function test_get_user_tasks(): void {
        $responseBody = $this->getUserTestInfo();

        $task = Task::where('user_id', $responseBody->user_id)->first();
        $datex = strtotime($task->task_date);
        $formattedDate = date('Y-m-d', $datex);

        $response = $this->withHeaders([
            'Authorization' => $responseBody->full_token
        ])->get('/api/' . $task->user_id . '/task/' . $formattedDate);

        $response->assertStatus(200);
    }

    public function test_incorrect_get_tasks_missing_auth(): void
    {
        $task = Task::first();
        $datex = strtotime($task["task_date"]);
        $formattedDate = date('Y-m-d', $datex);
        $response = $this->withHeaders([
            'Authorization' => 'No token'
        ])->get('/api/' . $task["user_id"] . "/task/" . $formattedDate);

        $response->assertStatus(401);
    }

    /*
     * POST endpoint
     */

     public function test_creation_task() : void {
        $responseBody = $this->getUserTestInfo();
        $task = new Task([
            "text" => "Test12!",
            "completed" => 1,
            "task_date" => date("Y-m-d"),
            "user_id" => $responseBody->user_id
        ]);

        $response = $this->withHeaders([
            'Authorization' => $responseBody->full_token
        ])->post('/api/' . $responseBody->user_id . '/task/' . date('Y-m-d'), [
            "text" => "Test!",
            "completed" => 1
        ]);

        $response->assertStatus(200);
    }

     public function test_incorrect_creation_task_missing_auth() : void {
        $responseBody = $this->getUserTestInfo();

        $response = $this->withHeaders([
            'Authorization' => ''
        ])->post('/api/' . $responseBody->user_id . '/task/' . date('Y-m-d'), [
            "text" => "Test!",
            "completed" => 1
        ]);

        $response->assertStatus(401);
    }

     public function test_incorrect_creation_task_missing_fields() : void {
        $responseBody = $this->getUserTestInfo();

        $response = $this->withHeaders([
            'Authorization' => $responseBody->full_token
        ])->post('/api/' . $responseBody->user_id . '/task/' . date('Y-m-d'), [
            "completed" => 1
        ]);

        $response->assertStatus(400);
    }

     /*
     * PATCH endpoint
     */

     public function test_update_task() : void {
        $responseBody = $this->getUserTestInfo();

        $task = Task::where('user_id', $responseBody->user_id)->first();
        $response = $this->withHeaders([
            'Authorization' => $responseBody->full_token
        ])->patch('/api/' . $responseBody->user_id . '/task', [
            "text" => "Test!",
            "completed" => 1,
            "id" => $task->id
        ]);

        $response->assertStatus(200);
    }

     public function test_incorrect_update_task_missing_auth() : void {
        $responseBody = $this->getUserTestInfo();

        $task = Task::where('user_id', $responseBody->user_id)->first();
        $response = $this->withHeaders([
            'Authorization' => ''
        ])->patch('/api/' . $responseBody->user_id . '/task', [
            "text" => "Test!",
            "completed" => 1,
            "id" => $task->id
        ]);

        $response->assertStatus(401);
    }

     public function test_incorrect_update_task_missing_task_id() : void {
        $responseBody = $this->getUserTestInfo();

        $task = Task::where('user_id', $responseBody->user_id)->first();
        $response = $this->withHeaders([
            'Authorization' => $responseBody->full_token
        ])->patch('/api/' . $responseBody->user_id . '/task', [
            "text" => "Test!",
            "completed" => 1
        ]);

        $response->assertStatus(400);
    }

     public function test_incorrect_update_task_missing_fields() : void {
        $responseBody = $this->getUserTestInfo();

        $task = Task::where('user_id', $responseBody->user_id)->first();
        $response = $this->withHeaders([
            'Authorization' => $responseBody->full_token
        ])->patch('/api/' . $responseBody->user_id . '/task', [
            "completed" => 1,
            "id" => $task->id
        ]);

        $response->assertStatus(400);
    }
    /*
     * DELETE endpoint
     */
    public function test_delete_task() : void {
        $responseBody = $this->getUserTestInfo();

        $task = new Task([
            "text" => "newTaskTest",
            "completed" => 1,
            "task_date" => date("Y-m-d"),
            "user_id" => $responseBody->user_id
        ]);
        $task->save();
        $response = $this->withHeaders([
            'Authorization' => $responseBody->full_token
        ])->delete('/api/' . $responseBody->user_id . '/task/' . $task->id);

        $response->assertStatus(200);
    }

}
