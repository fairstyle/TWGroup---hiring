<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('tasks_home');
});

Auth::routes();

// TASK
// === Get
Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index'])->middleware('auth')->name('tasks_home');

// === Create
Route::get('/tasks/new', [App\Http\Controllers\TaskController::class, 'create'])->middleware('auth')->name('task_create');
Route::post('/tasks/new', [App\Http\Controllers\TaskController::class, 'created'])->middleware('auth')->name('task_created');

// === Update
Route::get('/tasks/update/{task}', [App\Http\Controllers\TaskController::class, 'update'])->middleware('auth')->name('task_update');
Route::put('/tasks/update/{task}', [App\Http\Controllers\TaskController::class, 'updated'])->middleware('auth')->name('task_updated');

// === Delete
Route::delete('/tasks/{task}', [App\Http\Controllers\TaskController::class, 'destroy'])->middleware('auth')->name('task_delete');

// LOGS
// === Get
Route::get('/logs/{task}', [App\Http\Controllers\LogController::class, 'index'])->middleware('auth')->name('log');

// === Create
Route::get('/logs/{task}/new', [App\Http\Controllers\LogController::class, 'create'])->middleware('auth')->name('logs_create');
Route::post('/logs/{task}/new', [App\Http\Controllers\LogController::class, 'created'])->middleware('auth')->name('logs_created');


