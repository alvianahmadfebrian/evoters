<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Cms\DashboardController;
use App\Http\Controllers\Cms\CmsEventController;
use App\Http\Controllers\Cms\CandidateController;
use App\Http\Controllers\Cms\TokenController;
use App\Http\Controllers\Cms\CmsArticleController;
use App\Http\Controllers\AiChatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Voter Routes
Route::get('/', [VotingController::class, 'index'])->name('home');
Route::get('/events', [VotingController::class, 'listEvents'])->name('events.list');
Route::get('/berita', [VotingController::class, 'listArticles'])->name('news.index');
Route::get('/berita/{slug}', [VotingController::class, 'showArticle'])->name('news.show');
Route::get('/about', [VotingController::class, 'about'])->name('about');
Route::get('/faq', [VotingController::class, 'faq'])->name('faq');
Route::get('/syarat-ketentuan', [VotingController::class, 'terms'])->name('terms');
Route::get('/refund-policy', [VotingController::class, 'refundPolicy'])->name('refund');
Route::get('/kontak', [VotingController::class, 'contact'])->name('contact');
Route::get('/event/{slug}', [VotingController::class, 'showEvent'])->name('event.show');
Route::post('/event/{slug}/otp', [VotingController::class, 'requestOtp'])->name('event.otp');
Route::post('/event/{slug}/vote', [VotingController::class, 'submitVote'])->name('event.vote');
Route::get('/event/{slug}/results', [VotingController::class, 'showResults'])->name('event.results');
Route::get('/vote/{vote}/pay', [VotingController::class, 'showPayment'])->name('vote.pay');
Route::get('/vote/{vote}/status', [VotingController::class, 'checkStatus'])->name('vote.status');
Route::get('/vote/{vote}/download-qr', [VotingController::class, 'downloadQr'])->name('vote.download.qr');
Route::post('/vote/{vote}/pay/confirm', [VotingController::class, 'confirmPayment'])->name('vote.pay.confirm');
Route::post('/payment/notification', [VotingController::class, 'handleNotification'])->name('payment.notification');
Route::post('/ai/chat', [AiChatController::class, 'chat'])->name('ai.chat');

// Voter User Auth Routes
Route::get('/login', [AuthController::class, 'showUserLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Auth Routes (Direct entry to CMS)
Route::get('/cms-admin/login', [AuthController::class, 'showLogin'])->name('cms.login');
Route::post('/cms-admin/login', [AuthController::class, 'login']);

// Admin CMS Routes (Protected with auth and admin role check)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('cms.dashboard');
    
    // Events CRUD
    Route::get('/events', [CmsEventController::class, 'index'])->name('cms.events.index');
    Route::get('/events/create', [CmsEventController::class, 'create'])->name('cms.events.create');
    Route::post('/events', [CmsEventController::class, 'store'])->name('cms.events.store');
    Route::get('/events/{event}', [CmsEventController::class, 'show'])->name('cms.events.show');
    Route::get('/events/{event}/edit', [CmsEventController::class, 'edit'])->name('cms.events.edit');
    Route::match(['put', 'post'], '/events/{event}', [CmsEventController::class, 'update'])->name('cms.events.update');
    Route::delete('/events/{event}', [CmsEventController::class, 'destroy'])->name('cms.events.destroy');

    // Candidate CRUD
    Route::post('/events/{event}/candidates', [CandidateController::class, 'store'])->name('cms.candidates.store');
    Route::get('/candidates/{candidate}/edit', [CandidateController::class, 'edit'])->name('cms.candidates.edit');
    Route::match(['put', 'post'], '/candidates/{candidate}', [CandidateController::class, 'update'])->name('cms.candidates.update');
    Route::delete('/candidates/{candidate}', [CandidateController::class, 'destroy'])->name('cms.candidates.destroy');

    // Token Management
    Route::post('/events/{event}/tokens/generate', [TokenController::class, 'generate'])->name('cms.tokens.generate');
    Route::post('/events/{event}/tokens/clear', [TokenController::class, 'clear'])->name('cms.tokens.clear');
    Route::get('/events/{event}/tokens/export', [TokenController::class, 'export'])->name('cms.tokens.export');

    // Articles / News CRUD
    Route::get('/articles', [CmsArticleController::class, 'index'])->name('cms.articles.index');
    Route::get('/articles/create', [CmsArticleController::class, 'create'])->name('cms.articles.create');
    Route::post('/articles', [CmsArticleController::class, 'store'])->name('cms.articles.store');
    Route::get('/articles/{article}/edit', [CmsArticleController::class, 'edit'])->name('cms.articles.edit');
    Route::match(['put', 'post'], '/articles/{article}', [CmsArticleController::class, 'update'])->name('cms.articles.update');
    Route::delete('/articles/{article}', [CmsArticleController::class, 'destroy'])->name('cms.articles.destroy');
});
