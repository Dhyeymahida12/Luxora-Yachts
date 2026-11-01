<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EnquiryController as AdminEnquiryController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\SiteContentController;
use App\Http\Controllers\Admin\YachtController as AdminYachtController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\YachtController;
use App\Http\Middleware\EnsureAdminEmail;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/charter', [PageController::class, 'charter'])->name('charter');
Route::get('/yachts', [YachtController::class, 'index'])->name('yachts.index');
Route::get('/yachts/{yacht:slug}', [YachtController::class, 'show'])->name('yachts.show');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'send'])->name('contact.send');
Route::post('/newsletter', [PageController::class, 'subscribe'])->name('newsletter.subscribe');

foreach (['buy', 'build', 'design', 'destinations', 'sell', 'management', 'crew', 'about', 'news', 'careers'] as $page) {
    Route::get("/$page", [PageController::class, 'show'])->defaults('page', $page)->name($page);
}

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->middleware('throttle:6,1')->name('login.authenticate');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/account', [AccountController::class, 'index'])->middleware('auth')->name('account');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', EnsureAdminEmail::class])
    ->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::resource('yachts', AdminYachtController::class)->except('show');
        Route::get('/enquiries', [AdminEnquiryController::class, 'index'])->name('enquiries.index');
        Route::patch('/enquiries/{enquiry}', [AdminEnquiryController::class, 'update'])->name('enquiries.update');
        Route::get('/content', [SiteContentController::class, 'index'])->name('content.index');
        Route::get('/content/{page}/edit', [SiteContentController::class, 'edit'])->name('content.edit');
        Route::put('/content/{page}', [SiteContentController::class, 'update'])->name('content.update');
        Route::get('/newsletter', [NewsletterController::class, 'index'])->name('newsletter.index');
        Route::get('/newsletter/export', [NewsletterController::class, 'export'])->name('newsletter.export');
    });
