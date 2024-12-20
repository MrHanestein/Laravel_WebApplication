<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification
{
    use Queueable;

    protected $commenterName;
    protected $postTitle;

    /**
     * @param string $commenterName
     * @param string $postTitle
     */
    public function __construct($commenterName, $postTitle)
    {
        $this->commenterName = $commenterName;
        $this->postTitle = $postTitle;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => "{$this->commenterName} commented on your post: {$this->postTitle}"
        ];
    }
}

