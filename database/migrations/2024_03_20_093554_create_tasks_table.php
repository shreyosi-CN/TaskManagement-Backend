<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_name',50);
            $table->text('description')->nullable();
            $table->date('due_date')->comment("Enter the due date of the task");
            $table->integer('priority')->comment("Enter the priority of the task");
            $table->string('status')->default('Pending')->comment("Task status: Pending, In Progress, Completed");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
