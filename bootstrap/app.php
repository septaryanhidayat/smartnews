<?php

if (!enum_exists('SortDirection')) {
    enum SortDirection
    {
        case Ascending;
        case Descending;
    }
}

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Global web middleware: security headers + locale
        $middleware->web(append: [
            \App\Http\Middleware\SecurityHeaders::class,
            \App\Http\Middleware\SetLocaleMiddleware::class,
        ]);
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })
    ->booting(function () {
        // Rate limiters for security-critical endpoints
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->input('email', '') . '|' . $request->ip())
                ->response(function () {
                    return back()->withErrors([
                        'email' => 'Terlalu banyak percobaan login. Silakan coba lagi setelah 1 menit.',
                    ]);
                });
        });

        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip())
                ->response(function () {
                    return back()->withErrors([
                        'email' => 'Terlalu banyak percobaan pendaftaran. Silakan coba lagi setelah 1 menit.',
                    ]);
                });
        });

        RateLimiter::for('comment', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip())
                ->response(function () {
                    if ($request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Terlalu banyak komentar. Silakan coba lagi setelah 1 menit.',
                        ], 429);
                    }
                    return back()->withErrors([
                        'comment' => 'Terlalu banyak komentar. Silakan coba lagi setelah 1 menit.',
                    ]);
                });
        });
    })
    ->create();

