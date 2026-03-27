<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Notification;

class FollowedNotification extends Notification
{
    public function __construct(
        public readonly User $follower,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'follower_id'   => $this->follower->id,
            'follower_name' => $this->follower->name,
        ];
    }
}
