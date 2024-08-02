<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\BlogTagController;
use  App\Http\Controllers\BlogCategoryController;
use  App\Http\Controllers\BlogController;

Route::get('/', [BlogController::class, 'index'])->name('home.index');

Route::resource('blog_tags', BlogTagController::class);
Route::resource('blog_categories', BlogCategoryController::class);

Route::resource('blog', BlogController::class);
