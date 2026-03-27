<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request, User $user)
    {
        $posts = $user->posts()->withCount('likes')->latest()->get();
        $isFollowing = $request->user()->isFollowing($user);
        return view('users.show', compact('user', 'posts', 'isFollowing'));
    }
}
