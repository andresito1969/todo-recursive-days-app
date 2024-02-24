<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;

class TaskTest extends TestCase
{

    /*
     * GET endpoint
     */

    public function test_get_user_tasks(): void {
        $user = $this->post('/api/login', [
            'email' => 'andres@dev.com',
            'password' => 'test123'
        ]);

        $responseBody = json_decode($user->getContent());

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

     /*
     * PATCH endpoint
     */

    /*
     * DELETE endpoint
     */
}
