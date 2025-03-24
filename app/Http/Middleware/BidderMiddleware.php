<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidderMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('bidder')->check()) {
            return redirect()->route('bidder.login');
        }
        return $next($request);
    }
}
