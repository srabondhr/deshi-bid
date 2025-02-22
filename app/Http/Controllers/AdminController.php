<?php
use Illuminate\Http\Request;
use App\Models\AdminSetting;
use App\Models\User;

class AdminController extends Controller {
    public function updateSettings(Request $request) {
        AdminSetting::updateOrCreate(
            ['setting_name' => $request->setting_name],
            ['value' => $request->value]
        );

        return response()->json(['message' => 'Settings updated']);
    }

    public function banUser($id) {
        $user = User::findOrFail($id);
        $user->update(['status' => 'banned']);

        $user->notify(new AccountBanNotification());

        return response()->json(['message' => 'User banned']);
    }
}
