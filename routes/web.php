<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AuthController::class, 'showregister'])->name('showregister');
Route::post('/register', [AuthController::class, 'register'])->name('register');


Route::get('/login', [AuthController::class, 'showlogin'])->name('showlogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/get-cities', [AuthController::class, 'getCities'])->name('get.cities');

Route::get('/profile', [AuthController::class, 'editProfile'])->name('profile.edit');
Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');

// web.php
Route::get('/check-email', [AuthController::class, 'checkEmail'])->name('check-email');

// Route::get('/my-profile', [AuthController::class, 'profile'])->name('profile');
// Route::post('/my-profile', [AuthController::class, 'updateProfile'])->name('profile.update');

// Dashboard
// Route::get('/dashboard', [AuthController::class, 'dashboard'])
//     ->name('dashboard')
//     ->middleware('auth');

// Admin Only Route
Route::get('/admin',[AuthController::class,'dashboard'])->middleware(['auth', 'role:admin'])->name('admin.dashboard');

// User Only Route
Route::get('/user', [AuthController::class,'dashboard'])->middleware(['auth', 'role:user'])->name('user.dashboard');

