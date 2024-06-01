<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodolistController;
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

Route::get('/dashboard', [TodolistController::class, 'retrieve'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/tasks/{id}', [TodolistController::class, 'update'])->name('tasks.update');
    Route::post('/tasks', [TodolistController::class, 'add'])->name('tasks.add');
    Route::patch('/tasks/title/{id}', [TodolistController::class, 'updateTaskTitle'])->name('tasks.updateTaskTitle'); 
    Route::delete('/tasks/{id}', [TodolistController::class, 'deleteTask'])->name('tasks.delete');

});




require __DIR__.'/auth.php';
