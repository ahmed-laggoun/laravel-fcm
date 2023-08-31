<?php

namespace SmirlTech\LaravelFcm\Messages;

use http\Client\Response;
use SmirlTech\LaravelFcm\Enums\MessagePriority;
use SmirlTech\LaravelFcm\Facades\LaravelFcm;

class FirebaseMessage
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

    public function withAdditionalData(?array $additionalData): static
    {
        $this->additionalData = $additionalData;

        return $this;
    }

    public function withPriority(?MessagePriority $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function fromArray(?array $fromArray): static
    {
        $this->fromArray = $fromArray;

        return $this;
    }

    /**
     * @param array|string $deviceTokens
     * @return \Illuminate\Http\Client\Response
     */
    public function asNotification(array|string $deviceTokens): \Illuminate\Http\Client\Response
    {
        if ($this->fromArray) {
            return LaravelFcm::fromArray($this->fromArray)->sendNotification($deviceTokens);
        }

        return LaravelFcm::withTitle($this->title)
            ->withBody($this->body)
            ->withClickAction($this->clickAction)
            ->withImage($this->image)
            ->withIcon($this->icon)
            ->withSound($this->sound)
            ->withPriority($this->priority)
            ->withAdditionalData($this->additionalData)
            ->sendNotification($deviceTokens);
    }

    /**
     * @param array|string $deviceTokens
     * @return \Illuminate\Http\Client\Response
     */
    public function asMessage(array|string $deviceTokens): \Illuminate\Http\Client\Response
    {
        if ($this->fromArray) {
            return LaravelFcm::fromArray($this->fromArray)->sendMessage($deviceTokens);
        }

        return LaravelFcm::withTitle($this->title)
            ->withBody($this->body)
            ->withAdditionalData($this->additionalData)
            ->sendMessage($deviceTokens);
    }
}
