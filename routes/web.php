<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\BalitaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Orangtua\DashboardOrangtuaController;
use App\Http\Controllers\Petugas\DashboardPetugasController;

use App\Http\Controllers\Petugas\BalitaPetugasController;

use App\Http\Controllers\Petugas\UserPetugasController;
use App\Http\Controllers\Petugas\InspectionPetugasController;

use App\Http\Controllers\InspectionController;
use App\Http\Controllers\Orangtua\ReportController;
use App\Http\Controllers\Orangtua\ProfilesController;
use App\Http\Controllers\EventtimeController;

Route::get('/user', [UserController::class, 'index'])->name('user.index'); // list + filter
Route::get('/user/create', [UserController::class, 'create'])->name('user.create'); // form tambah
Route::post('/user', [UserController::class, 'store'])->name('user.store'); // proses tambah
Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show'); // detail user
Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit'); // form edit
Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update'); // proses update
Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy'); // hapus user
Route::patch('/user/{user}/status', [UserController::class, 'updateStatus'])->name('user.updateStatus'); // update verifikasi
// Resource route untuk user (tanpa auth)
Route::get('user', [UserController::class, 'index'])->name('dashboard.admin.user.index'); 
Route::get('user/create', [UserController::class, 'create'])->name('dashboard.admin.user.create'); 
Route::post('user', [UserController::class, 'store'])->name('dashboard.admin.user.store');
Route::get('user/{user}', [UserController::class, 'show'])->name('dashboard.admin.user.show'); 
Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('dashboard.admin.user.edit'); 
Route::put('user/{user}', [UserController::class, 'update'])->name('dashboard.admin.user.update'); 
Route::delete('user/{user}', [UserController::class, 'destroy'])->name('dashboard.admin.user.destroy'); 

// Halaman utama
Route::get('/', fn () => view('welcome'))->name('welcome');

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard admin (tanpa middleware)
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard.admin.index');

// Alias agar route('dashboard') tidak error
Route::get('/dashboard', fn () => redirect()->route('dashboard.admin.index'))->name('dashboard');

// Balita routes for admin
Route::get('/admin/balita', [BalitaController::class, 'index'])->name('dashboard.admin.balita.index');
Route::get('/admin/balita/create', [BalitaController::class, 'create'])->name('dashboard.admin.balita.create');
Route::post('/admin/balita', [BalitaController::class, 'store'])->name('dashboard.admin.balita.store');
Route::get('/admin/balita/{balita}', [BalitaController::class, 'show'])->name('dashboard.admin.balita.show');
Route::get('/admin/balita/{balita}/edit', [BalitaController::class, 'edit'])->name('dashboard.admin.balita.edit');
Route::put('/admin/balita/{balita}', [BalitaController::class, 'update'])->name('dashboard.admin.balita.update');
Route::delete('/admin/balita/{balita}', [BalitaController::class, 'destroy'])->name('dashboard.admin.balita.destroy');

// Artikel routes (tanpa middleware)
Route::get('/admin/artikel', [ArtikelController::class, 'index'])->name('dashboard.admin.artikel.index');
Route::get('/admin/artikel/create', [ArtikelController::class, 'create'])->name('dashboard.admin.artikel.create');
Route::post('/admin/artikel', [ArtikelController::class, 'store'])->name('dashboard.admin.artikel.store');
Route::get('/admin/artikel/{id}', [ArtikelController::class, 'show'])->name('dashboard.admin.artikel.show');
Route::get('/admin/artikel/{id}/edit', [ArtikelController::class, 'edit'])->name('dashboard.admin.artikel.edit');
Route::delete('/admin/artikel/{id}', [ArtikelController::class, 'destroy'])->name('dashboard.admin.artikel.destroy');
Route::put('/admin/artikel/{id}', [ArtikelController::class, 'update'])->name('dashboard.admin.artikel.update');

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
Route::prefix('petugas')->name('dashboard.petugas.inspection.')->group(function () {
    Route::get('/kunjungan', [InspectionPetugasController::class, 'index'])->name('index');
    Route::get('/kunjungan/create', [InspectionPetugasController::class, 'create'])->name('create');
    Route::post('/kunjungan', [InspectionPetugasController::class, 'store'])->name('store');
    Route::get('/kunjungan/{inspection}/edit', [InspectionPetugasController::class, 'edit'])->name('edit');
    Route::put('/kunjungan/{inspection}', [InspectionPetugasController::class, 'update'])->name('update');
    Route::delete('/kunjungan/{inspection}', [InspectionPetugasController::class, 'destroy'])->name('destroy');
});

// Petugas event routes
Route::resource('petugas/event', App\Http\Controllers\Petugas\EventController::class)->names([
    'index' => 'dashboard.petugas.event.index',
    'create' => 'dashboard.petugas.event.create',
    'store' => 'dashboard.petugas.event.store',
    'show' => 'dashboard.petugas.event.show',
    'edit' => 'dashboard.petugas.event.edit',
    'update' => 'dashboard.petugas.event.update',
    'destroy' => 'dashboard.petugas.event.destroy',
]);


// Petugas balita routes
Route::prefix('petugas')->name('dashboard.petugas.balita.')->group(function () {
    Route::get('/balita', [BalitaPetugasController::class, 'index'])->name('index');
    Route::get('/balita/create', [BalitaPetugasController::class, 'create'])->name('create');
    Route::post('/balita', [BalitaPetugasController::class, 'store'])->name('store');
    Route::get('/balita/{balita}', [BalitaPetugasController::class, 'show'])->name('show');
    Route::get('/balita/{balita}/edit', [BalitaPetugasController::class, 'edit'])->name('edit');
    Route::put('/balita/{balita}', [BalitaPetugasController::class, 'update'])->name('update');
    Route::delete('/balita/{balita}', [BalitaPetugasController::class, 'destroy'])->name('destroy');
});

Route::prefix('petugas')->name('dashboard.petugas.user.')->group(function () {
    Route::get('user', [UserPetugasController::class, 'index'])->name('index'); 
    Route::get('user/create', [UserPetugasController::class, 'create'])->name('create'); 
    Route::post('user', [UserPetugasController::class, 'store'])->name('store');
    Route::get('user/{user}', [UserPetugasController::class, 'show'])->name('show'); 
    Route::get('user/{user}/edit', [UserPetugasController::class, 'edit'])->name('edit'); 
    Route::put('user/{user}', [UserPetugasController::class, 'update'])->name('update'); 
    Route::delete('user/{user}', [UserPetugasController::class, 'destroy'])->name('destroy'); 
});
// Dashboard orangtua
Route::get('/orangtua/dashboard', [DashboardOrangtuaController::class, 'index'])->name('dashboard.orangtua.index');
Route::get('/orangtua/reports', [ReportController::class, 'index'])->name('dashboard.orangtua.reports.index');
Route::get('/orangtua/reports/create', [ReportController::class, 'create'])->name('dashboard.orangtua.reports.create');
Route::post('/orangtua/reports', [ReportController::class, 'store'])->name('dashboard.orangtua.reports.store');
Route::get('/orangtua/reports/{id}', [ReportController::class, 'show'])->name('dashboard.orangtua.reports.show');
Route::get('/orangtua/reports/{id}/edit', [ReportController::class, 'edit'])->name('dashboard.orangtua.reports.edit');
Route::put('/orangtua/reports/{id}', [ReportController::class, 'update'])->name('dashboard.orangtua.reports.update');
Route::delete('/orangtua/reports/{id}', [ReportController::class, 'destroy'])->name('dashboard.orangtua.reports.destroy');

// Dashboard orangtua Profiles
Route::get('/orangtua/profiles', [ProfilesController::class, 'index'])->name('dashboard.orangtua.profiles.index');
Route::get('/orangtua/profiles/create', [ProfilesController::class, 'create'])->name('dashboard.orangtua.profiles.create');
Route::post('/orangtua/profiles', [ProfilesController::class, 'store'])->name('dashboard.orangtua.profiles.store');
Route::get('/orangtua/profiles/{id}/edit', [ProfilesController::class, 'edit'])->name('dashboard.orangtua.profiles.edit');
Route::put('/orangtua/profiles/{id}', [ProfilesController::class, 'update'])->name('dashboard.orangtua.profiles.update');
Route::get('/orangtua/profiles/{id}', [ProfilesController::class, 'show'])->name('dashboard.orangtua.profiles.show');
Route::delete('/orangtua/profiles/{id}', [ProfilesController::class, 'destroy'])->name('dashboard.orangtua.profiles.destroy');

// Status Verifikasi
Route::put('/user/{user}/verifikasi', [UserController::class, 'updateStatus'])->name('user.updateStatus');

//admin event time
Route::resource('eventtime', EventtimeController::class)->names([
    'index' => 'dashboard.admin.event.index',
    'create' => 'dashboard.admin.event.create',
    'store' => 'dashboard.admin.event.store',
    'show' => 'dashboard.admin.event.show',
    'edit' => 'dashboard.admin.event.edit',
    'update' => 'dashboard.admin.event.update',
    'destroy' => 'dashboard.admin.event.destroy',
]);
