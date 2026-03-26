<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;
    // 投稿一覧を表示
    public function index()
    {
        $posts = Post::with('user')->withCount('likes')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    // 投稿を保存
    public function store(StorePostRequest $request)
    {
        $request->user()->posts()->create([
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index');
    }

    // 投稿を削除
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index');
    }
}
