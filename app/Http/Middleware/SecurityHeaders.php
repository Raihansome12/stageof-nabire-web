<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Adds baseline security headers to every response. Laravel does not set
 * these by default (see security review finding #7).
 *
 * CSP is intentionally a starting point, not final — it allows the inline
 * scripts/styles and CDN-style patterns already used in the Blade views so
 * nothing on the public site breaks. Tighten it (drop 'unsafe-inline', add
 * nonces) as a follow-up once the asset pipeline is audited.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // HSTS only makes sense over HTTPS (and should only be sent once you're
        // confident the site will always be served over HTTPS going forward).
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        if (! $response->headers->has('Content-Security-Policy')) {
            $response->headers->set(
                'Content-Security-Policy',
                "default-src 'self'; ".
                "connect-src 'self' https://unpkg.com https://cdn.jsdelivr.net; ".
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://unpkg.com https://cdn.jsdelivr.net; ".
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://unpkg.com; ".
                "img-src 'self' data: https:; ".
                "font-src 'self' data: https://fonts.gstatic.com; ".
                "frame-src 'self' blob: https://maps.google.com https://www.google.com https://jam.bmkg.go.id https://drive.google.com; ".
                "object-src 'self' blob: data:; ". 
                "frame-ancestors 'self'; ".
                "base-uri 'self'; ".
                "form-action 'self'"
            );
        }

        return $response;
    }
}