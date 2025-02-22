<?php
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller {
    public function getUserNotifications() {
        return response()->json(auth()->user()->notifications);
    }
}
