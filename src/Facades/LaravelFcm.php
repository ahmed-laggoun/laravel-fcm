<?php

namespace SmirlTech\LaravelFcm\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static fromArray(array $fromArray)
 * @method static withTitle(string $title)
 * @method static withBody(string $body)
 * @method static withClickAction(string $clickAction)
 * @method static withImage(string $image)
 * @method static withIcon(string $icon)
 * @method static withSound(string $sound)
 * @method static withPriority(string $priority)
 * @method static withAdditionalData(string $additionalData)
 * @method static withNotification(Notification $notification)
 * @method static withData(array $data)
 * @method static withAndroidConfig(AndroidConfig $androidConfig)
 * @method static withApnsConfig(ApnsConfig $apnsConfig)
 * @method static withWebpushConfig(WebpushConfig $webpushConfig)
 * @method static withFcmOptions(FcmOptions $fcmOptions)
 */
class LaravelFcm extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return self::class;
    }
}
