<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\BalitaController;
use App\Http\Controllers\UserController;  // Import UserController hanya sekali
use App\Http\Controllers\Orangtua\DashboardOrangtuaController;
use App\Http\Controllers\Petugas\DashboardPetugasController;
use App\Http\Controllers\Petugas\BalitaPetugasController;
use App\Http\Controllers\Petugas\UserPetugasController;
use App\Http\Controllers\Petugas\InspectionPetugasController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\Orangtua\ReportController;
use App\Http\Controllers\Orangtua\ProfilesController;
use App\Http\Controllers\EventtimeController;

// Routes untuk admin user (prefix admin)
Route::prefix('admin')->name('dashboard.admin.user.')->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('index');
    Route::get('/user/create', [UserController::class, 'create'])->name('create');
    Route::post('/user', [UserController::class, 'store'])->name('store');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('show');
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('destroy');
    Route::patch('/user/{user}/status', [UserController::class, 'updateStatus'])->name('updateStatus');
});

// Landing page
Route::get('/', fn () => view('welcome'))->name('welcome');

// Routes untuk user biasa
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');  // list + filter
    Route::get('/create', [UserController::class, 'create'])->name('create');  // form tambah
    Route::post('/', [UserController::class, 'store'])->name('store');  // proses tambah
    Route::get('/{user}', [UserController::class, 'show'])->name('show');  // detail user
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');  // form edit
    Route::put('/{user}', [UserController::class, 'update'])->name('update');  // proses update
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');  // hapus user
    Route::patch('/{user}/status', [UserController::class, 'updateStatus'])->name('updateStatus');  // update verifikasi
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard admin
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard.admin.index');

// Alias route dashboard
Route::get('/dashboard', fn () => redirect()->route('dashboard.admin.index'))->name('dashboard');

// Balita routes for admin
Route::prefix('admin')->name('dashboard.admin.balita.')->group(function () {
    Route::get('/balita', [BalitaController::class, 'index'])->name('index');
    Route::get('/balita/create', [BalitaController::class, 'create'])->name('create');
    Route::post('/balita', [BalitaController::class, 'store'])->name('store');
    Route::get('/balita/{balita}', [BalitaController::class, 'show'])->name('show');
    Route::get('/balita/{balita}/edit', [BalitaController::class, 'edit'])->name('edit');
    Route::put('/balita/{balita}', [BalitaController::class, 'update'])->name('update');
    Route::delete('/balita/{balita}', [BalitaController::class, 'destroy'])->name('destroy');
});

// Artikel routes for admin
Route::prefix('admin')->name('dashboard.admin.artikel.')->group(function () {
    Route::get('/artikel', [ArtikelController::class, 'index'])->name('index');
    Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('create');
    Route::post('/artikel', [ArtikelController::class, 'store'])->name('store');
    Route::get('/artikel/{id}', [ArtikelController::class, 'show'])->name('show');
    Route::get('/artikel/{id}/edit', [ArtikelController::class, 'edit'])->name('edit');
    Route::put('/artikel/{id}', [ArtikelController::class, 'update'])->name('update');
    Route::delete('/artikel/{id}', [ArtikelController::class, 'destroy'])->name('destroy');
});

// Inspection routes for admin
Route::prefix('admin')->name('dashboard.admin.inspection.')->group(function () {
    Route::get('/kunjungan', [InspectionController::class, 'index'])->name('index');
    Route::get('/kunjungan/create', [InspectionController::class, 'create'])->name('create');
    Route::post('/kunjungan', [InspectionController::class, 'store'])->name('store');
    Route::get('/kunjungan/{inspection}/edit', [InspectionController::class, 'edit'])->name('edit');
    Route::put('/kunjungan/{inspection}', [InspectionController::class, 'update'])->name('update');
    Route::delete('/kunjungan/{inspection}', [InspectionController::class, 'destroy'])->name('destroy');
});

// Dashboard petugas
Route::get('/petugas/dashboard', [DashboardPetugasController::class, 'index'])->name('dashboard.petugas.index');

Route::prefix('petugas')->group(function () {
    // Inspection petugas routes
    Route::name('dashboard.petugas.inspection.')->group(function () {
        Route::get('/kunjungan', [InspectionPetugasController::class, 'index'])->name('index');
        Route::get('/kunjungan/create', [InspectionPetugasController::class, 'create'])->name('create');
        Route::post('/kunjungan', [InspectionPetugasController::class, 'store'])->name('store');
        Route::get('/kunjungan/{inspection}/edit', [InspectionPetugasController::class, 'edit'])->name('edit');
        Route::put('/kunjungan/{inspection}', [InspectionPetugasController::class, 'update'])->name('update');
        Route::delete('/kunjungan/{inspection}', [InspectionPetugasController::class, 'destroy'])->name('destroy');
    });

    // Event petugas resource routes
    Route::resource('event', App\Http\Controllers\Petugas\EventController::class)->names([
        'index' => 'dashboard.petugas.event.index',
        'create' => 'dashboard.petugas.event.create',
        'store' => 'dashboard.petugas.event.store',
        'show' => 'dashboard.petugas.event.show',
        'edit' => 'dashboard.petugas.event.edit',
        'update' => 'dashboard.petugas.event.update',
        'destroy' => 'dashboard.petugas.event.destroy',
    ]);

    // Balita petugas routes
    Route::name('dashboard.petugas.balita.')->group(function () {
        Route::get('/balita', [BalitaPetugasController::class, 'index'])->name('index');
        Route::get('/balita/create', [BalitaPetugasController::class, 'create'])->name('create');
        Route::post('/balita', [BalitaPetugasController::class, 'store'])->name('store');
        Route::get('/balita/{balita}', [BalitaPetugasController::class, 'show'])->name('show');
        Route::get('/balita/{balita}/edit', [BalitaPetugasController::class, 'edit'])->name('edit');
        Route::put('/balita/{balita}', [BalitaPetugasController::class, 'update'])->name('update');
        Route::delete('/balita/{balita}', [BalitaPetugasController::class, 'destroy'])->name('destroy');
    });

    // User petugas routes
    // User petugas routes
    Route::name('dashboard.petugas.user.')->group(function () {
        Route::get('user', [UserPetugasController::class, 'index'])->name('index');
        Route::get('user/create', [UserPetugasController::class, 'create'])->name('create');
        Route::post('user', [UserPetugasController::class, 'store'])->name('store');
        Route::get('user/{user}', [UserPetugasController::class, 'show'])->name('show');
        Route::get('user/{user}/edit', [UserPetugasController::class, 'edit'])->name('edit');
        Route::put('user/{user}', [UserPetugasController::class, 'update'])->name('update');
        Route::delete('user/{user}', [UserPetugasController::class, 'destroy'])->name('destroy');
        Route::put('user/{user}/update-status', [UserPetugasController::class, 'updateStatus'])->name('updateStatus');
    });
});


// Dashboard orangtua routes
Route::prefix('orangtua')->name('dashboard.orangtua.')->group(function () {
    Route::get('/dashboard', [DashboardOrangtuaController::class, 'index'])->name('index');

    Route::get('/berita', [DashboardOrangtuaController::class, 'berita'])->name('berita.index');

    Route::get('/berita/{id}', [DashboardOrangtuaController::class, 'showBerita'])->name('berita.show');

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/create', [ReportController::class, 'create'])->name('create');
        Route::post('/', [ReportController::class, 'store'])->name('store');
        Route::get('/{id}', [ReportController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ReportController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ReportController::class, 'update'])->name('update');
        Route::delete('/{id}', [ReportController::class, 'destroy'])->name('destroy');
    });

    // Profiles
    Route::prefix('profiles')->name('profiles.')->group(function () {
        Route::get('/', [ProfilesController::class, 'index'])->name('index');
        Route::get('/create', [ProfilesController::class, 'create'])->name('create');
        Route::post('/', [ProfilesController::class, 'store'])->name('store');
        Route::get('/{id}', [ProfilesController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ProfilesController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProfilesController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProfilesController::class, 'destroy'])->name('destroy');
    });
});

// Status Verifikasi User
Route::put('/user/{user}/verifikasi', [UserController::class, 'updateStatus'])->name('user.updateStatus');

// Event time resource routes for admin
Route::resource('eventtime', EventtimeController::class)->names([
    'index' => 'dashboard.admin.event.index',
    'create' => 'dashboard.admin.event.create',
    'store' => 'dashboard.admin.event.store',
    'show' => 'dashboard.admin.event.show',
    'edit' => 'dashboard.admin.event.edit',
    'update' => 'dashboard.admin.event.update',
    'destroy' => 'dashboard.admin.event.destroy',
]);
