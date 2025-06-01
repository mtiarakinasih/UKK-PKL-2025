<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PklController;
use App\Http\Controllers\IndustriController; 
use App\Http\Controllers\GuruController;
use App\Http\Controllers\WelcomeController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->get('/dashboard', function () {
        $role = auth()->user()->role;

        return match ($role) {
            'guru' => redirect('/guru/dashboard'),
            'siswa' => redirect('/siswa/dashboard'),
            'admin' => redirect('/admin'),
            default => abort(403),
        };
    })->name('dashboard');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/guru/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
    Route::get('/siswa/dashboard', [PklController::class, 'index'])->name('siswa.dashboard');
    Route::get('/siswa/industri', [IndustriController::class, 'index'])->name('siswa.industri'); 
    Route::get('/siswa/industri/{id}', [IndustriController::class, 'show'])->name('siswa.industri.show');
    Route::get('/api/industri', [IndustriController::class, 'getIndustries'])->name('api.industri');
    Route::get('/siswa/profil', fn () => Inertia::render('Siswa/Profil'))->name('siswa.profil');
    Route::get('/siswa/pkl/add', [PklController::class, 'create'])->name('siswa.pkl.add');
    Route::post('/siswa/industri/store', [IndustriController::class, 'store'])->name('siswa.industri.store');
    Route::post('/siswa/pkl/store', [PklController::class, 'store'])->name('siswa.pkl.store');
});