<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\ortu\OrtuController;
use App\Http\Controllers\superadmin\BooksController;
use App\Http\Controllers\superadmin\ClassroomController;
use App\Http\Controllers\Superadmin\SuperAdminController;

use App\Http\Controllers\SuperAdmin\UserController as SuperadminUser;
use App\Http\Controllers\superadmin\YearBookController;


use App\Http\Controllers\Ortu\BooksController as OrtuBooksController;
use App\Http\Controllers\ortu\OrdersController;
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
            'orangtua' => 'orangtua.dashboard',
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
        case 'orangtua':
            return redirect()->route('ortu.dashboard');
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


Route::prefix('orangtua')->middleware(['auth', 'role:orangtua'])->group(function () {
    Route::get('/dashboard', [OrtuController::class, 'index'])->name('ortu.dashboard');

    Route::get('/books', [OrtuBooksController::class, 'index'])->name('ortu.books.index');
    Route::post('/books', [OrtuBooksController::class, 'store'])->name('ortu.books.store');
    Route::put('/books/{id}', [OrtuBooksController::class, 'update'])->name('ortu.books.update');
    Route::delete('/books/{id}', [OrtuBooksController::class, 'destroy'])->name('ortu.books.destroy');

    Route::post('/ortu/books/cart', [OrtuBooksController::class, 'addToCart'])->name('ortu.books.cart');
    Route::post('/ortu/books/remove', [OrtuBooksController::class, 'removeFromCart'])->name('ortu.books.remove');


    Route::post('/orders', [OrdersController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}', [OrdersController::class, 'show'])->name('orders.show');
    Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');

    Route::patch('/orders/{order}/item/{detail}', [OrdersController::class, 'updateQuantity'])->name('orders.updateQuantity');
    Route::delete('/orders/{order}/item/{detail}', [OrdersController::class, 'deleteItem'])->name('orders.deleteItem');
    Route::delete('/orders/{order}/cancel', [OrdersController::class, 'cancel'])->name('orders.cancel');
});

// Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
// });

// Route::prefix('superadmin')->middleware(['auth', 'level:superadmin'])->group(function () {
//     Route::get('/dashboard', [OrtuController::class, 'index'])->name('superadmin.dashboard');
// });
