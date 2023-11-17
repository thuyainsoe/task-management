<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Department;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        Task::factory(10)->create();

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

        $this->call([
            TagsSeeder::class
        ]);
    }
}
