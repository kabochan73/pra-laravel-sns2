<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use AuthorizesRequests;
    // 投稿一覧を表示
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $posts = Post::with('user')
            ->withCount('likes')
            ->when($keyword, fn($q) => $q->where('content', 'like', "%{$keyword}%"))
            ->latest()
            ->get();

        return view('posts.index', compact('posts', 'keyword'));
    }

    // 投稿を保存
    public function store(StorePostRequest $request)
    {
        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('post_images', 'public')
            : null;

        $request->user()->posts()->create([
            'content' => $request->content,
            'image'   => $imagePath,
        ]);

        return back();
    }

    // 投稿を削除
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();
        return redirect()->route('posts.index');
    }
}
