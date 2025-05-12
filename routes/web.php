<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\BalitaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Orangtua\DashboardOrangtuaController;
use App\Http\Controllers\Petugas\DashboardPetugasController;

// Resource route untuk user
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

// Balita routes
Route::get('/admin/balita', [BalitaController::class, 'index'])->name('dashboard.admin.balita.index');
Route::get('/admin/balita/create', [BalitaController::class, 'create'])->name('dashboard.admin.balita.create');
Route::post('/admin/balita', [BalitaController::class, 'store'])->name('dashboard.admin.balita.store');
Route::get('/admin/balita/{balita}', [BalitaController::class, 'show'])->name('dashboard.admin.balita.show');
Route::get('/admin/balita/{balita}/edit', [BalitaController::class, 'edit'])->name('dashboard.admin.balita.edit');
Route::put('/admin/balita/{balita}', [BalitaController::class, 'update'])->name('dashboard.admin.balita.update');
Route::delete('/admin/balita/{balita}', [BalitaController::class, 'destroy'])->name('dashboard.admin.balita.destroy');

// Artikel routes
Route::get('/admin/artikel', [ArtikelController::class, 'index'])->name('dashboard.admin.artikel.index');
Route::get('/admin/artikel/create', [ArtikelController::class, 'create'])->name('dashboard.admin.artikel.create');
Route::post('/admin/artikel', [ArtikelController::class, 'store'])->name('dashboard.admin.artikel.store');
Route::get('/admin/artikel/{id}', [ArtikelController::class, 'show'])->name('dashboard.admin.artikel.show');
Route::get('/admin/artikel/{id}/edit', [ArtikelController::class, 'edit'])->name('dashboard.admin.artikel.edit');
Route::delete('/admin/artikel/{id}', [ArtikelController::class, 'destroy'])->name('dashboard.admin.artikel.destroy');
Route::put('/admin/artikel/{id}', [ArtikelController::class, 'update'])->name('dashboard.admin.artikel.update');

// Dashboard petugas
Route::get('/petugas/dashboard', [DashboardPetugasController::class, 'index'])->name('dashboard.petugas.index');

// Dashboard orangtua
Route::get('/orangtua/dashboard', [DashboardOrangtuaController::class, 'index'])->name('dashboard.orangtua.index');

