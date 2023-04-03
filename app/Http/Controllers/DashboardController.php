<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function allNotifications() {
        foreach (auth()->user()->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        return view('all-notifications');
    }

    public function readAllNotification(Request $request) {
        foreach (auth()->user()->unreadNotifications as $notification) {
            $notification->markAsRead();
        }

        return redirect()->back()->with('message', 'Notifications mark as read successfully.');
    }
}
