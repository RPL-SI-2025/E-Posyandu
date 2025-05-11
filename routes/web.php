<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    return match ($role) {
        'admin' => view('dashboards.admin.index'),
        'petugas' => view('dashboards.petugas.index'),
        'orangtua' => view('dashboards.orangtua.index'),
        default => redirect('/')
    };
})->name('dashboard');
