<?php

namespace SmirlTech\LaravelFcm\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use SmirlTech\LaravelFcm\Enums\MessagePriority;
use SmirlTech\LaravelFcm\Exceptions\UnsupportedTokenFormat;

class LaravelFcm
{

    private ?string $title = null;

    private ?string $body= null;

    private ?string $clickAction= null;

    private ?string $image= null;

    private ?string $icon= null;

    private ?array $additionalData= null;

    private ?string $sound=null;

    private MessagePriority $priority = MessagePriority::normal;

    private ?array $fromArray=null;

    private ?string $authenticationKey=null;

    private ?array $fromRaw=null;

    const API_URI = 'https://fcm.googleapis.com/fcm/send';

    public function withTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function withBody(?string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function withClickAction(?string $clickAction): static
    {
        $this->clickAction = $clickAction;

        return $this;
    }

    public function withImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function withIcon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function withSound(?string $sound): static
    {
        $this->sound = $sound;

        return $this;
    }

    public function withPriority(?MessagePriority $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function withAdditionalData(?array $additionalData): static
    {
        $this->additionalData = $additionalData;

        return $this;
    }

    public function withAuthenticationKey(?string $authenticationKey): static
    {
        $this->authenticationKey = $authenticationKey;

        return $this;
    }

    public function fromArray(?array $fromArray): static
    {
        $this->fromArray = $fromArray;

        return $this;
    }

    public function fromRaw(?array $fromRaw): static
    {
        $this->fromRaw = $fromRaw;

        return $this;
    }

    /**
     * @throws UnsupportedTokenFormat
     */
    public function sendNotification(array|string $tokens): Response
    {
        $fields = array(
            'registration_ids' => $this->validateToken($tokens),
            'notification' => ($this->fromArray) ? $this->fromArray : [
                'title' => $this->title,
                'body' => $this->body,
                'image' => $this->image,
                'icon' => $this->icon,
                'sound' => $this->sound,
                'click_action' => $this->clickAction
            ],
            'data' => $this->additionalData,
            'priority' => $this->priority
        );

        return $this->callApi($fields);
    }

    /**
     * @throws UnsupportedTokenFormat
     */
    public function sendMessage(array|string $tokens): Response
    {
        $data = ($this->fromArray) ?: [
            'title' => $this->title,
            'body' => $this->body,
        ];

        $data = $this->additionalData ? array_merge($data, $this->additionalData) : $data;

        $fields = array(
            'registration_ids' => $this->validateToken($tokens),
            'data' => $data,
        );

        return $this->callApi($fields);
    }

    public function send(): Response
    {
        return $this->callApi($this->fromRaw);
    }

    private function callApi($fields): Response
    {
        $authenticationKey = $this->authenticationKey ?? config('laravel-fcm.server_key');

        return Http::withHeaders([
            'Authorization' => 'key=' . $authenticationKey
        ])->post(self::API_URI, $fields);
    }

    /**
     * @throws UnsupportedTokenFormat
     */
    private function validateToken(array|string $tokens): array
    {
        if (is_array($tokens)) {
            return $tokens;
        }

        if (is_string($tokens)) {
            return explode(',', $tokens);
        }

        throw new UnsupportedTokenFormat('Please pass tokens as array [token1, token2] or as string (use comma as separator if multiple passed).');
    }
}
