<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Notifications\Notification;

class LikedNotification extends Notification
{
    public function __construct(
        public readonly User $liker,
        public readonly Post $post,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'liker_id'   => $this->liker->id,
            'liker_name' => $this->liker->name,
            'post_id'    => $this->post->id,
            'post_content' => mb_substr($this->post->content, 0, 30),
        ];
    }
}
