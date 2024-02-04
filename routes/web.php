<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ResultsController;
use App\Http\Controllers\SingleEventController;
use App\Http\Controllers\SurveyController;
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

// Welcome
Route::get('/', function () {
    return view('welcome');
})->middleware('guest')
    ->name('welcome');

// Homepage
Route::get('/dashboard', [Controller::class, 'dashboard'])
    ->middleware(['auth', 'verified', 'approved'])
    ->name('dashboard');

// Approval Request
Route::get('/approval-request', function () {
    return view('approval_request');
})->middleware(['auth', 'approved.redirect'])
    ->name('approval.request');

// Groups
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

// Events
Route::get('/groups/{group}/events', [EventController::class, 'index'])
    ->middleware(['auth', 'verified', 'approved', 'is_member'])
    ->name('events.index');
Route::get('/groups/{group}/events/{event}', [EventController::class, 'show'])
    ->middleware(['auth', 'verified', 'approved', 'is_member'])
    ->name('events.show');
Route::get('/groups/{group}/events-create', [EventController::class, 'create'])
    ->middleware(['auth', 'verified', 'approved', 'is_admin'])
    ->name('events.create');
Route::post('/groups/{group}/events', [EventController::class, 'store'])
    ->middleware(['auth', 'verified', 'approved', 'is_admin'])
    ->name('events.store');
Route::delete('/groups/{group}/events/{event}', [EventController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'approved', 'is_admin'])
    ->name('events.destroy');
Route::post('/groups/{group}/events/{event}/end', [EventController::class, 'end'])
    ->middleware(['auth', 'verified', 'approved', 'is_admin'])
    ->name('events.end');
Route::post('/groups/{group}/events/{event}/cancel', [EventController::class, 'cancel'])
    ->middleware(['auth', 'verified', 'approved', 'is_admin'])
    ->name('events.cancel');
Route::get('groups/{group}/events/{event}/room', [EventController::class, 'room'])
    ->middleware(['auth', 'verified', 'approved', 'is_member'])
    ->name('events.room');

// SingleEvents
Route::get('/single-events', [SingleEventController::class, 'index'])
    ->middleware(['auth', 'verified', 'approved'])
    ->name('single_events.index');
Route::get('/single-events/{singleEvent}', [SingleEventController::class, 'show'])
    ->middleware(['auth', 'verified', 'approved'])
    ->name('single_events.show');
Route::get('/single-events-create', [SingleEventController::class, 'create'])
    ->middleware(['auth', 'verified', 'approved', 'is_admin'])
    ->name('single_events.create');
Route::post('/single-events', [SingleEventController::class, 'store'])
    ->middleware(['auth', 'verified', 'approved', 'is_admin'])
    ->name('single_events.store');
Route::delete('/single-events/{singleEvent}', [SingleEventController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'approved', 'is_admin'])
    ->name('single_events.destroy');
Route::post('/single-events/{singleEvent}/end', [SingleEventController::class, 'end'])
    ->middleware(['auth', 'verified', 'approved', 'is_admin'])
    ->name('single_events.end');
Route::post('/single-events/{singleEvent}/cancel', [SingleEventController::class, 'cancel'])
    ->middleware(['auth', 'verified', 'approved', 'is_admin'])
    ->name('single_events.cancel');
Route::get('/single-events/{singleEvent}/lobby', [SingleEventController::class, 'lobby'])
    ->middleware(['auth', 'verified', 'approved'])
    ->name('single_events.lobby');

// Posts
Route::get('/groups/{group}/posts', [PostController::class, 'index'])
    ->middleware(['auth', 'verified', 'approved', 'is_member'])
    ->name('posts.index');
Route::get('/groups/{group}/posts/{post}', [PostController::class, 'show'])
    ->middleware(['auth', 'verified', 'approved', 'is_member'])
    ->name('posts.show');
Route::get('/groups/{group}/posts-create', [PostController::class, 'create'])
    ->middleware(['auth', 'verified', 'approved', 'is_member'])
    ->name('posts.create');
Route::post('/groups/{group}/posts', [PostController::class, 'store'])
    ->middleware(['auth', 'verified', 'approved', 'is_member'])
    ->name('posts.store');
Route::delete('/groups/{group}/posts/{post}', [PostController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'approved', 'is_member'])
    ->name('posts.destroy');

// Comments
Route::post('/groups/{group}/posts/{post}', [CommentController::class, 'store'])
    ->middleware(['auth', 'verified', 'approved', 'is_member'])
    ->name('comments.store');
Route::delete('/groups/{group}/posts/{post}/comments/{comment}', [CommentController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'approved', 'is_member'])
    ->name('comments.destroy');

// Replies
Route::post('/groups/{group}/posts/{post}/comments/{comment}', [ReplyController::class, 'store'])
    ->middleware(['auth', 'verified', 'approved', 'is_member'])
    ->name('replies.store');
Route::delete('/groups/{group}/posts/{post}/comments/{comment}/replies/{reply}', [ReplyController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'approved', 'is_member'])
    ->name('replies.destroy');

// Attachments
Route::get('/groups/{group}/posts/{post}/attachments/{attachment}-{attachment_name}', [AttachmentController::class, 'show'])
    ->middleware(['auth', 'verified', 'approved', 'is_member'])
    ->name('attachments.show');

// Pending Users
Route::get('/pending-users', [AdminController::class, 'showPendingUsers'])
    ->middleware(['auth', 'verified', 'approved', 'is_admin'])
    ->name('admin.pending_users');
Route::patch('/approve-user/{user}', [AdminController::class, 'approveUser'])
    ->middleware(['auth', 'verified', 'is_admin'])
    ->name('admin.approve_user');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('approved')
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


//Survey
Route::get('/survey', [SurveyController::class,'index'])->name('survey.index');
Route::get('/survey/create', [SurveyController::class,'create'])->name('survey.create');
Route::post('/survey/create', [SurveyController::class,'store'])->name('survey.store');
Route::get('/survey/{survey}', [SurveyController::class,'show'])->name('survey.show');
Route::get('/survey/{survey}/questions/create',[QuestionController::class,'create'])->name('question.create');
Route::post('/survey/{survey}/questions/create',[QuestionController::class,'store'])->name('question.store');
Route::get('/survey/take/{survey}-{slug}',[SurveyController::class,'take'])->name('survey.take');
Route::post('/survey/take/{survey}-{slug}',[SurveyController::class,'takeStore'])->name('survey.takeStore');
Route::delete('/survey/{survey}/questions/{question}',[QuestionController::class,'delete'])->name('question.delete');
Route::get('/survey/results/{survey}',[ResultsController::class,'take'])->name('results.take');





require __DIR__.'/auth.php';
