<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminSetting;
use App\Models\User;
use App\Notifications\AccountBanNotification;

class AdminController extends Controller
{
    public function updateSettings(Request $request)
    {
        AdminSetting::updateOrCreate(
            ['setting_name' => $request->setting_name],
            ['value' => $request->value]
        );

        return response()->json(['message' => 'Settings updated']);
    }

    public function banUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'banned']);

        $user->notify(new AccountBanNotification());

        return response()->json(['message' => 'User banned']);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }
}
