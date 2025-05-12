<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\UserController;

Route::resource('user', UserController::class);

// Halaman utama
Route::get('/', fn () => view('welcome'))->name('welcome');

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard admin
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard.admin.index');

// Alias agar route('dashboard') tidak error
Route::get('/dashboard', fn () => redirect()->route('dashboard.admin.index'))->name('dashboard');
