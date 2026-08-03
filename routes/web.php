<?php

use App\Http\Controllers\RuleController;
use App\Http\Controllers\KuisionerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/rules', [RuleController::class, 'index'])->name('rules.index');
    
    Route::post('/kuisioner/start', [KuisionerController::class, 'start'])->name('kuisioner.start');
    Route::get('/kuisioner', [KuisionerController::class, 'index'])->name('kuisioner.index');
    Route::post('/kuisioner/cabang', [KuisionerController::class, 'storeCabang'])->name('kuisioner.storeCabang');
    Route::get('/kuisioner/pertanyaan', [KuisionerController::class, 'pertanyaan'])->name('kuisioner.pertanyaan');
    Route::post('/kuisioner/store-cabang-jawaban', [KuisionerController::class, 'storeCabangJawaban'])->name('kuisioner.storeCabangJawaban');
    Route::post('/kuisioner/submit', [KuisionerController::class, 'submitAll'])->name('kuisioner.submitAll');
});

Route::get('/', function () {
    return auth()->check() ? redirect()->route('rules.index') : redirect()->route('login');
});
