<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // いいね
    public function store(Request $request, Post $post)
    {
        $post->likes()->create(['user_id' => $request->user()->id]);
        return back();
    }

    // いいね解除
    public function destroy(Request $request, Post $post)
    {
        $post->likes()->where('user_id', $request->user()->id)->delete();
        return back();
    }
}
