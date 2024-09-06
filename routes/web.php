<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\BlogTagController;
use  App\Http\Controllers\BlogCategoryController;
use  App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DayoffController;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});


Route::get('/', [BlogController::class, 'index'])->name('home.index');
Route::get('/', [BlogController::class, 'index'])->name('home.index');

Route::resource('blog_tags', BlogTagController::class);
Route::get('tags/data', [BlogTagController::class, 'getData'])->name('tags.data');
Route::resource('blog_categories', BlogCategoryController::class);
Route::get('categories/data', [BlogCategoryController::class, 'getData'])->name('categories.data');

Route::resource('blog', BlogController::class);
Route::get('blogs/data', [BlogController::class, 'getData'])->name('blogs.data');


Route::middleware(['auth'])->group(function () {
    Route::resource('dayoff', DayOffController::class)->except(['show']);
    Route::get('dayoff/data', [DayOffController::class, 'getData'])->name('dayoff.data');
    Route::get('dayoff/view/{id}', [DayOffController::class, 'view'])->name('dayoff.view');
    Route::put('/dayoff/approve/{id}', [DayOffController::class, 'approve'])->name('dayoff.approve');
});
