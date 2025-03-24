<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function redirectTo()
    {
        if (auth()->check()) {
            return match (auth()->user()->role) {
                'admin' => '/admin/dashboard',
                'bidder' => '/bidder/dashboard',
                'seller' => '/seller/dashboard',
                default => '/',
            };
        }
        return '/';
    }

    public function logout(Request $request)
    {
        auth()->logout();  // Logout user

        $request->session()->invalidate();  // Invalidate session
        $request->session()->regenerateToken();  // Regenerate CSRF token

        return redirect('/');  // Redirect to homepage
    }
}
