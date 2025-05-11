<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Orangtua\DashboardOrangtuaController;
use App\Http\Controllers\Petugas\DashboardPetugasController;


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

// Route untuk halaman artikel
Route::get('/admin/artikel', [ArtikelController::class, 'index'])->name('dashboard.admin.artikel.index');
Route::get('/admin/artikel/create', [ArtikelController::class, 'create'])->name('dashboard.admin.artikel.create');
Route::post('/admin/artikel', [ArtikelController::class, 'store'])->name('dashboard.admin.artikel.store');
Route::get('/admin/artikel/{id}', [ArtikelController::class, 'show'])->name('dashboard.admin.artikel.show');
Route::get('/admin/artikel/{id}/edit', [ArtikelController::class, 'edit'])->name('dashboard.admin.artikel.edit');
Route::delete('/admin/artikel/{id}', [ArtikelController::class, 'destroy'])->name('dashboard.admin.artikel.destroy');
Route::put('/admin/artikel/{id}', [ArtikelController::class, 'update'])->name('dashboard.admin.artikel.update');

// Route untuk halaman dashboard petugas
Route::get('/petugas/dashboard', [DashboardPetugasController::class, 'index'])->name('dashboard.petugas.index');

// Route untuk halaman dashboard orangtua
Route::get('/orangtua/dashboard', [DashboardOrangtuaController::class, 'index'])->name('dashboard.orangtua.index');
