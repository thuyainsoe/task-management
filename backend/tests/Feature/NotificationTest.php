<?php

namespace Tests\Feature;

use App\Models\Notification;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use DatabaseTransactions, WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_can_create_noti(): void
    {
        $data = [
            'user_id' => 1,
            'message' => 'Test Noti',
        ];

        $notification = Notification::create($data);

        $this->assertEquals($data['user_id'], $notification->user_id);
    }
}
