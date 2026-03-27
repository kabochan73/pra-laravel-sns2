@use('Illuminate\Support\Facades\Storage')
<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- プロフィールカード --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                        <p class="text-gray-500 text-sm mt-1">投稿数: {{ $posts->count() }}</p>
                        <p class="text-gray-500 text-sm">フォロワー: {{ $user->followers()->count() }} / フォロー中:
                            {{ $user->following()->count() }}</p>
                    </div>

                    @if (Auth::id() !== $user->id)
                        @if ($isFollowing)
                            <form method="POST" action="{{ route('follows.destroy', $user) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm">
                                    フォロー中
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('follows.store', $user) }}">
                                @csrf
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                    フォローする
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>

            {{-- 投稿フォーム（自分のプロフィールのみ） --}}
            @if (Auth::id() === $user->id)
                <x-post-form />
            @endif

            {{-- 投稿一覧 --}}
            @foreach ($posts as $post)
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between items-start">
                        <span class="text-gray-400 text-sm">{{ $post->created_at->diffForHumans() }}</span>

                        @if (Auth::id() === $post->user_id)
                            <form method="POST" action="{{ route('posts.destroy', $post) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 text-sm hover:text-red-600">削除</button>
                            </form>
                        @endif
                    </div>
                    <p class="mt-2 text-gray-700">{{ $post->content }}</p>

                    @if ($post->image)
                        <img src="{{ Storage::url($post->image) }}" alt="投稿画像"
                            class="mt-3 rounded-lg max-h-80 w-full object-cover">
                    @endif

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
