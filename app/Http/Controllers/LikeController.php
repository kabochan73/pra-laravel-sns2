<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Notifications\LikedNotification;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // いいね
    public function store(Request $request, Post $post)
    {
        $post->likes()->create(['user_id' => $request->user()->id]);

        // 自分の投稿へのいいねは通知しない
        if ($post->user_id !== $request->user()->id) {
            $post->user->notify(new LikedNotification($request->user(), $post));
        }

        return back();
    }

    // いいね解除
    public function destroy(Request $request, Post $post)
    {
        $post->likes()->where('user_id', $request->user()->id)->delete();
        return back();
    }
}
