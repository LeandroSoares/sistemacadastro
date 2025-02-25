<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeusDadosController;
use App\Http\Controllers\UserController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/meus-dados', [MeusDadosController::class, 'index'])
    ->middleware(['auth'])
    ->name('meus-dados');

// Rotas para gerenciamento de usuários
Route::prefix('users')->middleware(['web', 'auth'])->group(function () {
    // Rotas acessíveis por admin e manager
    Route::group(['middleware' => ['auth', 'can:manage users']], function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    });

    // Rota de exclusão - apenas admin
    Route::group(['middleware' => ['auth', 'can:delete users']], function () {
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});

require __DIR__ . '/auth.php';
