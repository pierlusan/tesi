<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->approved) {
        return view('dashboard');
    } else {
        return redirect()->route('approval.request');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/approval-request', function () {
    return view('approval_request');
})->middleware('auth')->name('approval.request');

Route::get('/pending-users', [
    AdminController::class, 'showPendingUsers'
])->middleware(['auth', 'verified'])->name('admin.pending_users');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
