<?php
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\UpdateUserActivity;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::view('/', 'welcome');

Route::get('/dashboard',[DashboardController::class ,'index'])
    ->middleware(['auth', 'verified','lastSeen','status'])
    ->name('dashboard');
    

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
    Route::get('/dashboard/{id}' , [ChatController::class, 'index'])->name('chat')->middleware(['auth','verified']);
    
    Route::get('/user/{userId}/block', [ChatController::class, 'blockUser'])->name('user.block');
    Route::get('/user/{userId}/unblock', [ChatController::class ,'unblock'])->name('user.unblock');
require __DIR__.'/auth.php';