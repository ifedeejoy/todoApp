<?php

use App\Http\Controllers\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [AuthController::class, 'register'])->name('user.create');
Route::post('login', [AuthController::class, 'login'])->name('user.login');
Route::apiResource('tasks', TasksController::class)->middleware('auth:api');
Route::get('filter-tasks/{status}', [TasksController::class, 'tasksByStatus'])->middleware('auth:api')->name('tasks.status');