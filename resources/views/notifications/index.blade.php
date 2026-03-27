<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            通知
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @forelse ($notifications as $notification)
                <div class="bg-white shadow-sm sm:rounded-lg p-4 text-sm text-gray-700">
                    @if ($notification->type === 'App\Notifications\LikedNotification')
                        <a href="{{ route('users.show', $notification->data['liker_id']) }}"
                            class="font-bold hover:underline">
                            {{ $notification->data['liker_name'] }}
                        </a>
                        さんが「{{ $notification->data['post_content'] }}」にいいねしました
                    @elseif ($notification->type === 'App\Notifications\FollowedNotification')
                        <a href="{{ route('users.show', $notification->data['follower_id']) }}"
                            class="font-bold hover:underline">
                            {{ $notification->data['follower_name'] }}
                        </a>
                        さんにフォローされました
                    @endif
                    <span class="text-gray-400 text-xs ml-2">{{ $notification->created_at->diffForHumans() }}</span>
                </div>
            @empty
                <p class="text-center text-gray-400">通知はありません</p>
            @endforelse

        </div>
    </div>
</x-app-layout>
