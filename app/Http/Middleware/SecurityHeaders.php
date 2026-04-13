<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Prevent MIME type sniffing.
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        // Reduce leaked referrer details on cross-origin navigation.
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        // Block clickjacking by disallowing framing.
        $response->headers->set('X-Frame-Options', 'DENY');
        // Disable high-risk browser features by default.
        $response->headers->set(
            'Permissions-Policy',
            'accelerometer=(), autoplay=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=()'
        );

        // CSP is intentionally permissive enough for typical Laravel + Livewire/Vite setups.
        $response->headers->set('Content-Security-Policy', $this->contentSecurityPolicy());

        // Apply HSTS only on HTTPS requests.
        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');

        return $response;
    }

    private function contentSecurityPolicy(): string
    {
        return implode('; ', [
            "default-src 'self'",
            "base-uri 'self'",
            "frame-ancestors 'none'",
            "object-src 'none'",
            "form-action 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https:",
            "style-src 'self' 'unsafe-inline' https:",
            "img-src 'self' data: blob: https:",
            "font-src 'self' data: https:",
            "connect-src 'self' https: wss: ws:",
            "frame-src 'self' https:",
            "upgrade-insecure-requests",
        ]);
    }
}