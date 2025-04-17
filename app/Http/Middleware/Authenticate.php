<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Check if the user is a customer
        if (Auth::guard('customerGuard')->check() === false) {
            notify()->info('You need to log in first');
            return route('customer.login');
        }

        // admin login
        return route('admin.login');
    }
}
