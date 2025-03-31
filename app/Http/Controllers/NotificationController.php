<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function index() 
    {
        return Inertia::render('notifications/Index', [
            'notifications' => Auth::user()->notifications
        ]);
    }

    public function edit($notificationId)
    {
        $notification = Auth::user()->notifications->where('id', $notificationId)->first();

        if ($notification->read_at) {
            $notification->update([
                'read_at' => null
            ]);
        } else {
            $notification->markAsRead();
        }

        return back();
    }

    public function destroy($notificationId)
    {
        $notification = Auth::user()->notifications->where('id', $notificationId)->first();

        $notification->delete();

        return back();
    }
}
