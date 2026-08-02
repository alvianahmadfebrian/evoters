<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Cms\DashboardController;
use App\Http\Controllers\Cms\CmsEventController;
use App\Http\Controllers\Cms\CandidateController;
use App\Http\Controllers\Cms\TokenController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Voter Routes
Route::get('/', [VotingController::class, 'index'])->name('home');
Route::get('/events', [VotingController::class, 'listEvents'])->name('events.list');
Route::get('/event/{slug}', [VotingController::class, 'showEvent'])->name('event.show');
Route::post('/event/{slug}/otp', [VotingController::class, 'requestOtp'])->name('event.otp');
Route::post('/event/{slug}/vote', [VotingController::class, 'submitVote'])->name('event.vote');
Route::get('/event/{slug}/results', [VotingController::class, 'showResults'])->name('event.results');
Route::get('/vote/{vote}/pay', [VotingController::class, 'showPayment'])->name('vote.pay');
Route::post('/vote/{vote}/pay/confirm', [VotingController::class, 'confirmPayment'])->name('vote.pay.confirm');
Route::post('/payment/notification', [VotingController::class, 'handleNotification'])->name('payment.notification');

// Admin Auth Routes
Route::get('/cms-admin/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/cms-admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');

// Admin CMS Routes (Protected)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('cms.dashboard');
    
    // Events CRUD
    Route::get('/events', [CmsEventController::class, 'index'])->name('cms.events.index');
    Route::get('/events/create', [CmsEventController::class, 'create'])->name('cms.events.create');
    Route::post('/events', [CmsEventController::class, 'store'])->name('cms.events.store');
    Route::get('/events/{event}', [CmsEventController::class, 'show'])->name('cms.events.show');
    Route::get('/events/{event}/edit', [CmsEventController::class, 'edit'])->name('cms.events.edit');
    Route::put('/events/{event}', [CmsEventController::class, 'update'])->name('cms.events.update');
    Route::delete('/events/{event}', [CmsEventController::class, 'destroy'])->name('cms.events.destroy');

    // Candidate CRUD
    Route::post('/events/{event}/candidates', [CandidateController::class, 'store'])->name('cms.candidates.store');
    Route::get('/candidates/{candidate}/edit', [CandidateController::class, 'edit'])->name('cms.candidates.edit');
    Route::put('/candidates/{candidate}', [CandidateController::class, 'update'])->name('cms.candidates.update');
    Route::delete('/candidates/{candidate}', [CandidateController::class, 'destroy'])->name('cms.candidates.destroy');

    // Token Management
    Route::post('/events/{event}/tokens/generate', [TokenController::class, 'generate'])->name('cms.tokens.generate');
    Route::post('/events/{event}/tokens/clear', [TokenController::class, 'clear'])->name('cms.tokens.clear');
    Route::get('/events/{event}/tokens/export', [TokenController::class, 'export'])->name('cms.tokens.export');
});
