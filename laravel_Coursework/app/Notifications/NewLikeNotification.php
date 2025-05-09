<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewLikeNotification extends Notification
{
    use Queueable;

    protected $likerName;
    protected $itemDescription;

    /**
     * @param string $likerName
     * @param string $itemDescription (could be post title or 'your comment')
     */
    public function __construct($likerName, $itemDescription)
    {
        $this->likerName = $likerName;
        $this->itemDescription = $itemDescription;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => "{$this->likerName} liked {$this->itemDescription}",
        ];
    }

}
