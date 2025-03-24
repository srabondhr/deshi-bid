<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidderController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('bidder')->attempt($credentials)) {
            return redirect()->route('bidder.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }
}
