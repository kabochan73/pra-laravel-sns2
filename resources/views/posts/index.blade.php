@use('Illuminate\Support\Facades\Storage')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            投稿一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 投稿フォーム --}}
            <x-post-form />

            {{-- 投稿一覧 --}}
            @foreach ($posts as $post)
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <a href="{{ route('users.show', $post->user) }}"
                                class="font-bold text-gray-800 hover:underline">{{ $post->user->name }}</a>
                            <span class="text-gray-400 text-sm ml-2">{{ $post->created_at->diffForHumans() }}</span>
                        </div>

                        {{-- 自分の投稿だけ削除ボタンを表示 --}}
                        @if (Auth::id() === $post->user_id)
                            <form method="POST" action="{{ route('posts.destroy', $post) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-400 text-sm hover:text-red-600 border border-red-400 px-2 py-1 rounded">
                                    削除
                                </button>
                            </form>
                        @endif
                    </div>
                    <p class="mt-2 text-gray-700">{{ $post->content }}</p>

                    {{-- 画像表示 --}}
                    @if ($post->image)
                        <img src="{{ Storage::url($post->image) }}" alt="投稿画像"
                            class="mt-3 rounded-lg max-h-80 w-full object-cover">
                    @endif

                    {{-- いいねボタン --}}
                    <div class="mt-3 flex justify-end">
                        @if ($post->isLikedBy(Auth::user()))
                            <form method="POST" action="{{ route('likes.destroy', $post) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 text-sm hover:text-red-700">
                                    ❤ {{ $post->likes_count }}
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('likes.store', $post) }}">
                                @csrf
                                <button type="submit" class="text-gray-400 text-sm hover:text-red-500">
                                    ♡ {{ $post->likes_count }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach

            @if ($posts->isEmpty())
                <p class="text-center text-gray-400">まだ投稿がありません</p>
            @endif

        </div>
    </div>
</x-app-layout>
