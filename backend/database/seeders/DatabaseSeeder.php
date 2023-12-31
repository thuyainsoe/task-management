<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Assignment;
use App\Models\Department;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        User::query()->get()
            ->map(function($user) {
                $user->update([
                    'username' => 'https://ui-avatars.com/api/?name=' . $user->name
                ]);
            });

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'username' => 'https://ui-avatars.com/api/Test User',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'username' => 'https://ui-avatars.com/api/?name=TTTT',
        ]);

        // Task::factory(10)->create();

        Department::factory()->create([
            'name' => 'Adminstration'
        ]);

        Department::factory()->create([
            'name' => 'Admissions'
        ]);

        Department::factory()->create([
            'name' => 'Communications'
        ]);

        Department::factory()->create([
            'name' => 'IT'
        ]);

        Department::factory()->create([
            'name' => 'Student Affairs'
        ]);

        Department::factory()->create([
            'name' => 'Facilities'
        ]);

        Department::factory()->create([
            'name' => 'Trannsportation'
        ]);

        Department::factory()->create([
            'name' => 'Food Service'
        ]);

        Task::query()
            ->get()
            ->map(function($task) {
                Assignment::create([
                    'task_id' => $task->id,
                    'assigned_user_id' => rand(1, 10),
                    'assigned_by' => rand(1, 10),
                ]);
            });

        $this->call([
            TagsSeeder::class
        ]);
    }
}
