<div class="bg-white shadow-sm sm:rounded-lg p-6">
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        <textarea name="content" rows="3" maxlength="140" placeholder="いまどうしてる？（140文字以内）"
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('content') }}</textarea>

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
