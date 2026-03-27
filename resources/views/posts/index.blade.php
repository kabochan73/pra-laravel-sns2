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
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                    @csrf
                    <textarea name="content" rows="3" maxlength="140" placeholder="いまどうしてる？（140文字以内）"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('content') }}</textarea>

                    {{-- バリデーションエラー表示 --}}
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <div class="mt-3 flex justify-between items-center">
                        <div>
                            <label class="cursor-pointer text-gray-500 text-sm hover:text-indigo-500">
                                🖼 画像を追加
                                <input type="file" name="image" accept="image/*" class="hidden">
                            </label>
                            @error('image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600">
                            投稿する
                        </button>
                    </div>
                </form>
            </div>

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
