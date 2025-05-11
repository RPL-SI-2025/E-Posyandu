<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;


// Route untuk halaman utama (welcome)
Route::get('/', function () {
    return view('welcome'); // Mengarahkan ke view welcome.blade.php
})->name('welcome');

// Route untuk menampilkan halaman login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Route untuk menampilkan halaman register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

// Route untuk proses login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Route untuk proses register
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Route untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk halaman dashboard admin
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard.admin.index');