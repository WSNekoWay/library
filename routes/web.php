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

// satu resource itu isinya:
// Route::get('/members', [MemberController::class, 'listAll']);
// Route::get('/members/create', [MemberController::class, 'newForm']);
// Route::post('/members', [MemberController::class, 'saveMember']);
// Route::get('/members/{member}/edit', [MemberController::class, 'editForm']);
// Route::put('/members/{member}', [MemberController::class, 'updateDetails']);
// Route::delete('/members/{member}', [MemberController::class, 'removeMember']);
// variablenya sudah di fix in dengan index, show, etc untuk controller
// bisa custom:
// Route::resource('members', MemberController::class)->names([
//     'index' => 'listMembers',
//     'create' => 'newMemberForm',
//     'store' => 'saveMember',
//     'edit' => 'modifyMemberForm',
//     'update' => 'refreshMember',
//     'destroy' => 'deleteMember',
// ]);

// contoh kalau disuruh buat sendiri baru
// Route::get('/members/report', [MemberController::class, 'generateReport'])->name('members.report');
// Route::get('/members/search', [MemberController::class, 'search'])->name('members.search');