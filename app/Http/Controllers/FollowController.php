<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\FollowedNotification;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    // フォローする
    public function store(Request $request, User $user)
    {
        $request->user()->following()->attach($user->id);
        $user->notify(new FollowedNotification($request->user()));
        return back();
    }

    // フォロー解除する
    public function destroy(Request $request, User $user)
    {
        $request->user()->following()->detach($user->id);
        return back();
    }
}
