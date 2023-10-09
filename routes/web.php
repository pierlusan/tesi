<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PostController;
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
})->middleware('guest')
    ->name('welcome');

Route::get('/dashboard', [Controller::class, 'dashboard'])
    ->middleware(['auth', 'verified', 'approved'])
    ->name('dashboard');

Route::get('/approval-request', function () {
    return view('approval_request');
})->middleware(['auth', 'approved.redirect'])
    ->name('approval.request');

Route::get('/pending-users', [AdminController::class, 'showPendingUsers'])
    ->middleware(['auth', 'verified', 'approved', 'is_admin'])
    ->name('admin.pending_users');
Route::patch('/approve-user/{user}', [AdminController::class, 'approveUser'])
    ->middleware(['auth', 'verified', 'is_admin'])
    ->name('admin.approve_user');

Route::get('/groups', [GroupController::class, 'index'])
    ->middleware(['auth', 'verified', 'approved'])
    ->name('groups.index');
Route::get('/groups/{group}', [GroupController::class, 'show'])
    ->middleware(['auth', 'verified', 'approved', 'is_member'])
    ->name('groups.show');
Route::get('/groups-create', [GroupController::class, 'create'])
    ->middleware(['auth', 'verified', 'approved', 'is_admin'])
    ->name('groups.create');
Route::post('/groups', [GroupController::class, 'store'])
    ->middleware(['auth', 'verified', 'approved', 'is_admin'])
    ->name('groups.store');
Route::put('/groups/{group}', [GroupController::class, 'edit'])
    ->middleware(['auth', 'verified', 'approved', 'is_admin'])
    ->name('groups.edit');
Route::post('/groups/{group}/add', [GroupController::class, 'add'])
    ->middleware(['auth', 'verified', 'approved', 'is_admin'])
    ->name('groups.add');
Route::delete('/groups/{group}/remove-user/{user}', [GroupController::class, 'remove'])
    ->middleware(['auth', 'verified', 'approved', 'is_admin'])
    ->name('groups.remove');
Route::delete('/groups/{group}', [GroupController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'approved', 'is_admin'])
    ->name('groups.destroy');

Route::get('/groups/{group}/posts', [PostController::class, 'index'])
    ->middleware(['auth', 'verified', 'approved', 'is_member'])
    ->name('posts.index');
Route::get('/groups/{group}/posts/{post}', [PostController::class, 'show'])
    ->middleware(['auth', 'verified', 'approved', 'is_member'])
    ->name('posts.show');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('approved')
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
