<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Security headers middleware to harden SmartNews against common web attacks.
     *
     * - X-Frame-Options: Prevent clickjacking by blocking iframe embedding
     * - X-Content-Type-Options: Prevent MIME-type sniffing attacks
     * - X-XSS-Protection: Enable browser-level XSS filtering
     * - Referrer-Policy: Control referrer information leakage
     * - Permissions-Policy: Restrict access to browser APIs (camera, mic, etc.)
     * - Strict-Transport-Security: Force HTTPS connections
     * - X-Permitted-Cross-Domain-Policies: Prevent Adobe Flash/PDF cross-domain data loading
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent clickjacking — only allow framing from same origin
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Prevent MIME type sniffing — browser must respect declared Content-Type
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Enable XSS filter in older browsers (modern browsers have built-in protection)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Control referrer information sent with requests
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Restrict access to powerful browser features/APIs
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');

        // Force HTTPS for 1 year (only on HTTPS connections)
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // Prevent Adobe Flash/PDF cross-domain requests
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');

        return $response;
    }
}
