<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeusDadosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\OrishaController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('home', 'home')
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/meus-dados', [MeusDadosController::class, 'index'])
    ->middleware(['auth'])
    ->name('meus-dados');

// Rotas para gerenciamento de usuários
Route::prefix('users')->middleware(['web', 'auth'])->group(function () {
    // Rota de visualização
    Route::get('/', [UserController::class, 'index'])
        ->middleware('can:view users')
        ->name('users.index');

    // Rotas de criação
    Route::get('/create', [UserController::class, 'create'])
        ->middleware('can:create users')
        ->name('users.create');

    Route::post('/', [UserController::class, 'store'])
        ->middleware('can:create users')
        ->name('users.store');

    // Rotas de edição
    Route::get('/{user}/edit', [UserController::class, 'edit'])
        ->middleware('can:edit users')
        ->name('users.edit');

    Route::put('/{user}', [UserController::class, 'update'])
        ->middleware('can:edit users')
        ->name('users.update');

    // Rota de exclusão
    Route::delete('/{user}', [UserController::class, 'destroy'])
        ->middleware('can:delete users')
        ->name('users.destroy');
});

// Rotas para gerenciamento de cursos
Route::prefix('courses')->middleware(['auth'])->group(function () {
    // Rota de visualização
    Route::get('/', [CourseController::class, 'index'])
        ->middleware('can:view courses')
        ->name('courses.index');

    // Rotas de criação
    Route::get('/create', [CourseController::class, 'create'])
        ->middleware('can:create courses')
        ->name('courses.create');

    Route::post('/', [CourseController::class, 'store'])
        ->middleware('can:create courses')
        ->name('courses.store');

    // Rotas de edição
    Route::get('/{course}/edit', [CourseController::class, 'edit'])
        ->middleware('can:edit courses')
        ->name('courses.edit');

    Route::put('/{course}', [CourseController::class, 'update'])
        ->middleware('can:edit courses')
        ->name('courses.update');

    // Rota de exclusão
    Route::delete('/{course}', [CourseController::class, 'destroy'])
        ->middleware('can:delete courses')
        ->name('courses.destroy');
});

// Rotas para gerenciamento de orishas
Route::prefix('orishas')->middleware(['auth'])->group(function () {
    Route::get('/', [OrishaController::class, 'index'])
        ->middleware('can:view orishas')
        ->name('orishas.index');

    Route::get('/create', [OrishaController::class, 'create'])
        ->middleware('can:create orishas')
        ->name('orishas.create');

    Route::post('/', [OrishaController::class, 'store'])
        ->middleware('can:create orishas')
        ->name('orishas.store');

    Route::get('/{orisha}/edit', [OrishaController::class, 'edit'])
        ->middleware('can:edit orishas')
        ->name('orishas.edit');

    Route::put('/{orisha}', [OrishaController::class, 'update'])
        ->middleware('can:edit orishas')
        ->name('orishas.update');

    Route::delete('/{orisha}', [OrishaController::class, 'destroy'])
        ->middleware('can:delete orishas')
        ->name('orishas.destroy');
});

require __DIR__ . '/auth.php';
