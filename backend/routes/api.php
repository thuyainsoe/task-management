<?php

use App\Http\Controllers\Api\AssignmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Finder\Iterator\FilecontentFilterIterator;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', function(Request $request) {
    $auth = new AuthController();

    return $auth->login($request);
});

Route::post('/register', function(Request $request) {
    $auth = new AuthController();

    return $auth->register($request);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);

    Route::post('/tasks', [TaskController::class, 'store'])->middleware('only_admin');
    Route::post('/assignments', [AssignmentController::class, 'store'])->middleware('only_admin');

    Route::get('/notifications', [NotificationController::class, 'index']);

    Route::post('/files', [FileController::class, 'store']);

    Route::get('/tasks/{task_id}/files', [FileController::class, 'index']);
    Route::get('/tasks/{task_id}/comments', [TaskController::class, 'getComment']);
});

Route::get('/files/{id}/download', [FileController::class, 'download']);
