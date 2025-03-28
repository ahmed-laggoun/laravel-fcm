<p align="center"><img src="/art/cover.png" height="400"></p>

<p align="center">
    <a href="https://packagist.org/packages/smirltech/laravel-fcm">
        <img src="https://img.shields.io/packagist/dt/smirltech/laravel-fcm" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/smirltech/laravel-fcm">
        <img src="https://img.shields.io/packagist/v/smirltech/laravel-fcm" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/smirltech/laravel-fcm">
        <img src="https://img.shields.io/packagist/l/smirltech/laravel-fcm" alt="License">
    </a>
</p>


### Introduction

**LaravelFcm** is a package thats offers you to send push notifications or custom messages via Firebase in Laravel.

Firebase Cloud Messaging (FCM) is a cross-platform messaging solution that lets you reliably deliver messages at no cost.

For use cases such as instant messaging, a message can transfer a payload of up to 4KB to a client app.

### Installation

Follow the steps below to install the package.


**Composer**

```
composer require ahmed-laggoun/laravel-fcm
```

**Copy Config**

Run `php artisan vendor:publish --provider="SmirlTech\LaravelFcm\Providers\LaravelFcmServiceProvider"` to publish the `laravel-fcm.php` config file.

**Get Athentication Key**

Get Authentication Key from https://console.firebase.google.com/

**Configure laravel-fcm.php as needed**

```
'server_key' => '{FCM_SERVER_KEY}'
```

### Usage

Follow the steps below to find how to use the package.

Example usage in **Controller/Service** or any class:

```php
use SmirlTech\LaravelFcm\Facades\LaravelFcm;

class MyController
{
    private $deviceTokens =['{TOKEN_1}', '{TOKEN_2}'];

    public function sendNotification()
    {
        return LaravelFcm::withTitle('Test Title')
            ->withBody('Test body')
            ->withImage('https://firebase.google.com/images/social.png')
            ->withIcon('https://seeklogo.com/images/F/firebase-logo-402F407EE0-seeklogo.com.png')
            ->withSound('default')
            ->withClickAction('https://www.google.com')
            ->withPriority('high')
            ->withAdditionalData([
                'color' => '#rrggbb',
                'badge' => 0,
            ])
            ->sendNotification($this->deviceTokens);
        
        // Or
        return LaravelFcm::fromArray(['title' => 'Test Title', 'body' => 'Test body'])->sendNotification($this->deviceTokens);
    }

    public function sendMessage()
    {
        return LaravelFcm::withTitle('Test Title')
            ->withBody('Test body')
            ->sendMessage($this->deviceTokens);
            
        // Or
        return LaravelFcm::fromArray(['title' => 'Test Title', 'body' => 'Test body'])->sendMessage($this->deviceTokens);
    }
}
```

Example usage in **Notification** class:

```php
use Illuminate\Notifications\Notification;
use SmirlTech\LaravelFcm\Messages\FirebaseMessage;

class SendBirthdayReminder extends Notification
{
    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['firebase'];
    }

    /**
     * Get the firebase representation of the notification.
     */
    public function toFirebase($notifiable)
    {
        $deviceTokens = [
            '{TOKEN_1}',
            '{TOKEN_2}'
        ];
        
        return (new FirebaseMessage)
            ->withTitle('Hey, ', $notifiable->first_name)
            ->withBody('Happy Birthday!')
            ->asNotification($deviceTokens); // OR ->asMessage($deviceTokens);
    }
}
```


### Tips
- Check example how to receive messages or push notifications in a [JavaScript client](/javascript-client).
- You can use `laravelfcm()` helper instead of Facade.


### Payload

Check how is formed payload to send to firebase:

Example 1:

```php
laravelFcm::withTitle('Test Title')->withBody('Test body')->sendNotification('token1');
```

```json
{
  "registration_ids": [
    "token1"
  ],
  "notification": {
    "title": "Test Title",
    "body": "Test body"
  },
  "priority": "normal"
}
```

Example 2:

```php
laravelFcm::withTitle('Test Title')->withBody('Test body')->sendMessage('token1');
```

```json
{
  "registration_ids": [
    "token1"
  ],
  "data": {
    "title": "Test Title",
    "body": "Test body"
  }
}
```

If you want to create payload from scratch you can use method `fromRaw`, for example:

```php
return LaravelFbase::fromRaw([
    'registration_ids' => ['token1', 'token2'],
    'data' => [
        'key_1' => 'Value 1',
        'key_2' => 'Value 2'
    ],
    'android' => [
        'ttl' => '1000s',
        'priority' => 'normal',
        'notification' => [
            'key_1' => 'Value 1',
            'key_2' => 'Value 2'
        ],
    ],
])->send();
```

---

<sup>This package is a fork of [kutia-software-company/larafirebase](https://github.com/kutia-software-company/larafirebase)</sup>
