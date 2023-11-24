<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Controllers\API\Task\TaskController;
use App\Http\Controllers\API\Task\UserTaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/sanctum/token', [LoginController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/sanctum/logout', [LogoutController::class, 'logout']);
    Route::apiResource('users.tasks', UserTaskController::class)->only('store', 'index');
    Route::apiResource('tasks', TaskController::class)->only('update', 'destroy');
    Route::patch('tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
});
