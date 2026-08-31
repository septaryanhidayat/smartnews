<?php

use App\Http\Controllers\Admin\ArticleAdminController;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\CommentAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileAdminController;
use App\Http\Controllers\Admin\TagAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Front\ArticleController;
use App\Http\Controllers\Front\CategoryController;
use App\Http\Controllers\Front\CommentController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\SearchController;
use App\Http\Controllers\Front\TagController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - SmartNews Portal
|--------------------------------------------------------------------------
*/

// Front-End Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lang/{locale}', [\App\Http\Controllers\Front\LocaleController::class, 'switch'])->name('lang.switch');
Route::get('/berita/{slug}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/kategori/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/tag/{slug}', [TagController::class, 'show'])->name('tag.show');
Route::get('/cari', [SearchController::class, 'index'])->name('search');
Route::post('/berita/{slug}/komentar', [CommentController::class, 'store'])->name('comment.store');

// Static Pages
Route::get('/halaman/{page}', [PageController::class, 'show'])->name('page.show');
Route::get('/tentang-kami', fn() => redirect()->route('page.show', 'tentang-kami'))->name('page.about');
Route::get('/redaksi', fn() => redirect()->route('page.show', 'redaksi'))->name('page.redaksi');
Route::get('/pedoman-media-siber', fn() => redirect()->route('page.show', 'pedoman-media-siber'))->name('page.pedoman');
Route::get('/kode-etik', fn() => redirect()->route('page.show', 'kode-etik'))->name('page.kode-etik');
Route::get('/disclaimer', fn() => redirect()->route('page.show', 'kode-etik'))->name('page.disclaimer');
Route::get('/kontak', fn() => redirect()->route('page.show', 'kontak'))->name('page.kontak');
Route::get('/pasang-iklan', fn() => redirect()->route('page.show', 'pasang-iklan'))->name('page.pasang-iklan');
Route::get('/privacy-policy', fn() => redirect()->route('page.show', 'privacy-policy'))->name('page.privacy');
Route::get('/terms', fn() => redirect()->route('page.show', 'terms'))->name('page.terms');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/daftar', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::match(['get', 'post'], '/sync-database', [DashboardController::class, 'syncDatabase'])->name('sync-database');
    Route::post('/clear-logs', [DashboardController::class, 'clearLogs'])->name('logs.clear');

    // Articles (Accessible by all roles; authors scoped to own articles)
    Route::post('articles/upload-image', [ArticleAdminController::class, 'uploadImage'])->name('articles.upload-image');
    Route::post('articles/{id}/toggle-sticky', [ArticleAdminController::class, 'toggleSticky'])->name('articles.toggle-sticky');
    Route::resource('articles', ArticleAdminController::class)->except(['show']);

    // Categories (Admin & Editor only)
    Route::middleware('role:admin,editor')->group(function () {
        Route::resource('categories', CategoryAdminController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('tags', TagAdminController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::get('/comments', [CommentAdminController::class, 'index'])->name('comments.index');
        Route::post('/comments/{id}/toggle', [CommentAdminController::class, 'toggleApproval'])->name('comments.toggle');
        Route::delete('/comments/{id}', [CommentAdminController::class, 'destroy'])->name('comments.destroy');
    });

    // Super Admin Only Operations (Users, Ads, Settings)
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserAdminController::class)->except(['show']);
        Route::get('/settings', [App\Http\Controllers\Admin\SettingAdminController::class, 'index'])->name('settings.index');
        Route::put('/settings', [App\Http\Controllers\Admin\SettingAdminController::class, 'update'])->name('settings.update');
        Route::get('/ads', [App\Http\Controllers\Admin\AdAdminController::class, 'index'])->name('ads.index');
        Route::put('/ads', [App\Http\Controllers\Admin\AdAdminController::class, 'update'])->name('ads.update');
    });

    // Profile Settings (All authenticated users)
    Route::get('/profile', [ProfileAdminController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileAdminController::class, 'update'])->name('profile.update');
});

// Storage Asset Delivery Route (Ensures 100% reliable image delivery on all web servers)
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    if (file_exists($filePath)) {
        return response()->file($filePath);
    }
    return response()->file(public_path('images/default-news.webp'));
})->where('path', '.*');
