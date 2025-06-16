<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Public routes that don't require authentication
        $publicPaths = ['/', '/about', '/services', '/contact', '/properti', '/agents'];
        
        // Don't redirect to login if accessing public routes
        if (in_array($request->path(), $publicPaths) || 
            str_starts_with($request->path(), 'properti/') ||
            str_starts_with($request->path(), 'agents/')) {
            return null;
        }

        return route('login');
    }
}
