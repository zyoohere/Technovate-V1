<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [ArtikelController::class, 'index'])->name('artikels.index');
Route::get('/artikel/{slug}', [ArtikelController::class, 'show']);
Route::get('/kategori/{slug}', [CategoryController::class, 'show']);
Route::post('/komentar', [CommentController::class, 'store']);
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


Route::get('login/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('login/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

require __DIR__ . '/auth.php';
