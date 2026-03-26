<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        $posts = $user->posts()->withCount('likes')->latest()->get();
        return view('users.show', compact('user', 'posts'));
    }
}
