<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;

class TaskController extends BaseController
{
    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $request->validate([
                'task_name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'required|date',
                'priority' => 'required|integer',
            ]);
    
            // Create a new task instance with the request data
            $task = Task::create([
                'task_name' => $request->input('task_name'),
                'description' => $request->input('description'),
                'due_date' => $request->input('due_date'),
                'priority' => $request->input('priority')
            ]);
    
            // Check if task was created successfully
            if ($task) {
                return $this->sendResponse($task, 'Task created successfully.');
            } else {
                return $this->sendError('Failed to create task.', 500); // HTTP status code 500 for server error
            }
        } catch (\Exception $e) {
            // Log the exception for debugging
    
            // Return an error response with a generic message
            return $this->sendError('An unexpected error occurred.', 500); // HTTP status code 500 for server error
        }
    }
     /**
     * Display the specified resource.
     */

     public function getTask($id)
     {
         try {
             $task = Task::findOrFail($id);
             return $this->sendResponse($task, 'Task retrieved successfully.');
         } catch (\Exception $e) {
             return $this->sendError('Task not found.', [], 404);
         }
     }
     
    public function show($type)
    {

        try{
            switch($type)
            {
                case 'a' :
                     // Retrieve all tasks from the database
            $tasks = Task::all();
    
            return $this->sendResponse($tasks, 'Tasks retrieved successfully.');
            break;
    
            case 'c' :
    
                 // Retrieve completed tasks from the database
            $completedTasks = Task::where('status', 'Completed')->get();
    
            // Return JSON response with the completed tasks
            return $this->sendResponse($completedTasks, 'Completed tasks retrieved successfully.');
    
                break;
    
             case 'p' :
    
                 // Retrieve tasks that are in progress or pending from the database
            $inProgressAndPendingTasks = Task::whereIn('status', ['In Progress', 'Pending'])->get();
    
            // Return JSON response with the in-progress and pending tasks
            return $this->sendResponse($inProgressAndPendingTasks, 'In-progress and pending tasks retrieved successfully.');
                
                break;
    
            }

        }
        catch(\Exception $e) {
           
            return $this->sendError($e->getMessage()); // HTTP status code 500 for server error

        }
       
       
    }

  

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try{

             // Validate the incoming request data
        $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|string|in:Pending,In Progress,Completed',
            'priority' => 'required|integer',
        ]);

        // Find the task by its ID
        $task = Task::findOrFail($id);

        // Update the task with the new data
        $task->update([
            'task_name' => $request->input('task_name'),
            'description' => $request->input('description'),
            'due_date' => $request->input('due_date'),
            'priority' => $request->input('priority'),
            'status' => $request->input('status'),
        ]);

        // Return a success response
        return $this->sendResponse($task, 'Task updated successfully.');

        }
        catch(\Exception $e) {
           
            return $this->sendError($e->getMessage()); // HTTP status code 500 for server error

        }
       

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
             // Find the task by its ID
        $task = Task::findOrFail($id);

        // Delete the task
        $task->delete();

        // Return a success response
        return $this->sendResponse(null, 'Task deleted successfully.');

        }
        catch(\Exception $e) {
           
            return $this->sendError($e->getMessage()); // HTTP status code 500 for server error

        }
       
    }

    public function chartData()
    {

        try{
            $total = Task::count();
            $pending = Task::whereIn('status', ['In Progress', 'Pending'])->count();
            $completed = Task::where('status', 'Completed')->count();

             // Create an associative array with the task data
        $taskData = [
            'total' => $total,
            'pending' => $pending,
            'completed' => $completed
        ];

        return $this->sendResponse($taskData, 'Chart Details.');


        }catch (\Exception $e) {
           
            return $this->sendError($e->getMessage()); // HTTP status code 500 for server error

        }


    }
    
}
