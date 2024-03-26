<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::create([
            'task_name' => 'Task 1',
            'description' => 'Description of Task 1',
            'due_date' => '2024-04-01',
            'priority' => 1,
            'status' => 'Pending',
        ]);

        Task::create([
            'task_name' => 'Task 2',
            'description' => 'Description of Task 2',
            'due_date' => '2024-04-05',
            'priority' => 2,
            'status' => 'In Progress',
        ]);

        Task::create([
            'task_name' => 'Task 3',
            'description' => 'Description of Task 3',
            'due_date' => '2024-04-10',
            'priority' => 3,
            'status' => 'Completed',
        ]);


    }
}
