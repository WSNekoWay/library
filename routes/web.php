<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Middleware\ExecutionTimeMiddleware;


Route::resource('members', MemberController::class);
Route::resource('books', BookController::class);
Route::resource('borrows', BorrowController::class);
Route::resource('categories', CategoryController::class);
