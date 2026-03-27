<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // 通知一覧を表示して既読にする
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications()->latest()->get();
        $request->user()->unreadNotifications->markAsRead();
        return view('notifications.index', compact('notifications'));
    }
}
