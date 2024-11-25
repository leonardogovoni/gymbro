<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchedeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Pagina 'allenamento', per ora placeholder
Route::get('/training', function () {
    return view('training');
})->middleware(['auth', 'verified'])->name('training');

// Pagina delle schede, raggiungibile solo dopo aver effettuato il login
// GET | HEAD
Route::get('/schede', [SchedeController::class, 'index'])->middleware(['auth', 'verified'])->name('schede');
// POST, inserimento
Route::post('/schede', [SchedeController::class, 'store'])->name('schede.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
