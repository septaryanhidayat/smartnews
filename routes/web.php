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
Route::get('/berita/{slug}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/kategori/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/tag/{slug}', [TagController::class, 'show'])->name('tag.show');
Route::get('/cari', [SearchController::class, 'index'])->name('search');
Route::post('/berita/{slug}/komentar', [CommentController::class, 'store'])->name('comment.store');

// Static Pages
Route::get('/halaman/{page}', [PageController::class, 'show'])->name('page.show');
Route::get('/tentang-kami', fn() => redirect()->route('page.show', 'tentang-kami'))->name('page.about');
Route::get('/disclaimer', fn() => redirect()->route('page.show', 'disclaimer'))->name('page.disclaimer');
Route::get('/redaksi', fn() => redirect()->route('page.show', 'redaksi'))->name('page.redaksi');
Route::get('/pedoman-media-siber', fn() => redirect()->route('page.show', 'pedoman-media-siber'))->name('page.pedoman');
Route::get('/kontak', fn() => redirect()->route('page.show', 'kontak'))->name('page.kontak');

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

    // Articles
    Route::resource('articles', ArticleAdminController::class)->except(['show']);

    // Categories
    Route::resource('categories', CategoryAdminController::class)->only(['index', 'store', 'update', 'destroy']);

    // Tags
    Route::resource('tags', TagAdminController::class)->only(['index', 'store', 'update', 'destroy']);

    // Comments
    Route::get('/comments', [CommentAdminController::class, 'index'])->name('comments.index');
    Route::post('/comments/{id}/toggle', [CommentAdminController::class, 'toggleApproval'])->name('comments.toggle');
    Route::delete('/comments/{id}', [CommentAdminController::class, 'destroy'])->name('comments.destroy');

    // Users Management
    Route::resource('users', UserAdminController::class)->except(['show']);

    // Profile Settings
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
