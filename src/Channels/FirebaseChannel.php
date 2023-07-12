<?php

namespace SmirlTech\LaravelFcm\Channels;

use Illuminate\Notifications\Notification;
use SmirlTech\LaravelFcm\Messages\FirebaseMessage;

class FirebaseChannel
{
    /**
     * Send the given notification.
     */
    public function send($notifiable, Notification $notification): void
    {
        /** @var FirebaseMessage $message */
        $message = $notification->toFirebase($notifiable);
    }
}
