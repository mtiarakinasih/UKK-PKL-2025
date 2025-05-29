<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PklController;

// Halaman landing
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Redirect dinamis setelah login untuk siswa & guru
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->get('/dashboard', function () {
        $role = auth()->user()->role;

        return match ($role) {
            'guru' => redirect('/guru/dashboard'),
            'siswa' => redirect('/siswa/dashboard'),
            'admin' => redirect('/admin'), // Filament route
            default => abort(403),
        };
    })->name('dashboard');

// Dashboard khusus siswa dan guru
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/guru/dashboard', fn () => Inertia::render('Guru/Dashboard'))->name('guru.dashboard');
    Route::get('/siswa/dashboard', [PklController::class, 'index'])->name('siswa.dashboard');
    Route::get('/siswa/industri', fn () => Inertia::render('Siswa/Industri'))->name('siswa.industri');
    Route::get('/siswa/profil', fn () => Inertia::render('Siswa/Profil'))->name('siswa.profil');
});
