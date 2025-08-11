<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\ortu\OrtuController;
use App\Http\Controllers\superadmin\BooksController;
use App\Http\Controllers\superadmin\ClassroomController;
use App\Http\Controllers\Superadmin\SuperAdminController;

use App\Http\Controllers\SuperAdmin\UserController as SuperadminUser;
use App\Http\Controllers\superadmin\YearBookController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    if (Auth::check()) {
        // User sudah login, redirect ke dashboard sesuai level
        return redirect()->route(match (strtoupper(Auth::user()->level)) {
            'superadmin' => 'superadmin.dashboard',
            'admin' => 'admin.dashboard',
            default => 'home'
        });
    }

    return view('auth.login'); // Jika belum login, tampilkan halaman login
});

Auth::routes();

Route::get('/home', function () {
    $user = Auth::user();

    switch ($user->role) {
        case 'superadmin':
            return redirect()->route('superadmin.dashboard');
        case 'admin':
            return redirect()->route('admin.dashboard');
        default:
            return redirect()->route('welcome');
    }
})->middleware('auth')->name('home');


Route::prefix('superadmin')->middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('superadmin.dashboard');

    Route::get('/users', [SuperadminUser::class, 'index'])->name('superadmin.users.index');
    Route::post('/users', [SuperadminUser::class, 'store'])->name('superadmin.users.store');
    Route::put('/users/{id}', [SuperadminUser::class, 'update'])->name('superadmin.users.update');
    Route::delete('/users/{id}', [SuperadminUser::class, 'destroy'])->name('superadmin.users.destroy');

    Route::get('/yearBooks', [YearBookController::class, 'index'])->name('superadmin.yearBooks.index');
    Route::post('/yearBooks', [YearBookController::class, 'store'])->name('superadmin.yearBooks.store');
    Route::put('/yearBooks/{id}', [YearBookController::class, 'update'])->name('superadmin.yearBooks.update');
    Route::delete('/yearBooks/{id}', [YearBookController::class, 'destroy'])->name('superadmin.yearBooks.destroy');

    Route::get('/classRooms', [ClassroomController::class, 'index'])->name('superadmin.classRooms.index');
    Route::post('/classRooms', [ClassroomController::class, 'store'])->name('superadmin.classRooms.store');
    Route::put('/classRooms/{id}', [ClassroomController::class, 'update'])->name('superadmin.classRooms.update');
    Route::delete('/classRooms/{id}', [ClassroomController::class, 'destroy'])->name('superadmin.classRooms.destroy');

    Route::get('/books', [BooksController::class, 'index'])->name('superadmin.books.index');
    Route::post('/books', [BooksController::class, 'store'])->name('superadmin.books.store');
    Route::put('/books/{id}', [BooksController::class, 'update'])->name('superadmin.books.update');
    Route::delete('/books/{id}', [BooksController::class, 'destroy'])->name('superadmin.books.destroy');
});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::prefix('ortu')->middleware(['auth', 'role:ortu'])->group(function () {
    Route::get('/dashboard', [OrtuController::class, 'index'])->name('ortu.dashboard');
});


// Route::prefix('superadmin')->middleware(['auth', 'level:superadmin'])->group(function () {
//     Route::get('/dashboard', [OrtuController::class, 'index'])->name('superadmin.dashboard');
// });
