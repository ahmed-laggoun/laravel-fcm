<?php

namespace SmirlTech\LaravelFcm\Channels;

use Illuminate\Notifications\Notification;

class FirebaseChannel
{
    /**
     * Send the given notification.
     */
    public function send($notifiable, Notification $notification): void
    {
        /** @var \SmirlTech\LaravelFcm\FirebaseMessage $message */
        $message = $notification->toFirebase($notifiable);
    }
}
