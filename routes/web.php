<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// List Tasks
Route::get('/', [TaskController::class, 'index'])->name('tasks.index');

// Add New Task
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

// Update Task
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

// Delete Task
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
