<?php
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::view('/', 'welcome');

Route::get('/dashboard',[DashboardController::class ,'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
    Route::get('/dashboard/{id}' , [ChatController::class, 'index'])->name('chat')->middleware(['auth','verified']);
require __DIR__.'/auth.php';