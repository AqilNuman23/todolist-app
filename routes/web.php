<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodolistController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [TaskController::class, 'retrieve'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/group{id}', [GroupController::class, 'show'])->name('group.show');
    Route::post('/groups', [GroupController::class, 'create'])->name('groups.create');
    Route::patch('/group/{id}', [GroupController::class, 'updateGroupTitle'])->name('tasks.updateGroupTitle');
    Route::delete('/group/{id}', [GroupController::class, 'delete'])->name('groups.delete');
    
    Route::post('/tasks', [TaskController::class, 'create'])->name('tasks.create');
    Route::patch('/tasks/title/{id}', [TaskController::class, 'updateTaskTitle'])->name('tasks.updateTaskTitle'); 
    Route::patch('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}', [TaskController::class, 'delete'])->name('tasks.delete');
});





require __DIR__.'/auth.php';
