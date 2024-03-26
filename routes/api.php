<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;

use App\Http\Controllers\API\TaskController;

//Open Routes
Route::post("register",[RegisterController::class,"register"])->name("signup");
Route::post("/login",[RegisterController::class,"login"])->name("signin");


//protected routes
Route::group([
    "middleware" => ["auth:api"]],
    function()
    {
        Route::get("tasks/{type}",[TaskController::class,"show"]);
        Route::get("completedTask",[TaskController::class,"showC"]);
        Route::get("overdueTask",[TaskController::class,"showD"]);
        Route::post('/tasks', [TaskController::class, 'store']);
        Route::put('/tasks/{id}', [TaskController::class, 'update']);
        Route::get('/getTask/{id}', [TaskController::class, 'getTask']);

        Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);


        Route::get('/chartData', [TaskController::class, 'chartData']);


    }
);
