<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    // フォローする
    public function store(Request $request, User $user)
    {
        $request->user()->following()->attach($user->id);
        return back();
    }

    // フォロー解除する
    public function destroy(Request $request, User $user)
    {
        $request->user()->following()->detach($user->id);
        return back();
    }
}
