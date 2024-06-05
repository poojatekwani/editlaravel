<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('posts', [PostController::class, 'index']);
Route::get('posts/data', [PostController::class, 'getData'])->name('posts.data');
Route::get('posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::post('posts/{id}', [PostController::class, 'update'])->name('posts.update');