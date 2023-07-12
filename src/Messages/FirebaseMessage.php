<?php

namespace SmirlTech\LaravelFcm\Messages;

use SmirlTech\LaravelFcm\Enums\MessagePriority;
use SmirlTech\LaravelFcm\Facades\LaravelFcm;

class FirebaseMessage
{

    private string $title;

    private string $body;

    private string $clickAction;

    private string $image;

    private string $icon;

    private string $sound;

    private string $additionalData;

    private MessagePriority $priority = MessagePriority::normal;

    private array $fromArray;

    public function withTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function withBody(string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function withClickAction(string $clickAction): static
    {
        $this->clickAction = $clickAction;

        return $this;
    }

    public function withImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function withIcon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function withSound(string $sound): static
    {
        $this->sound = $sound;

        return $this;
    }

    public function withAdditionalData(string $additionalData): static
    {
        $this->additionalData = $additionalData;

        return $this;
    }

    public function withPriority(MessagePriority $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function fromArray(array $fromArray): static
    {
        $this->fromArray = $fromArray;

        return $this;
    }

    public function asNotification($deviceTokens)
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

    public function asMessage($deviceTokens)
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
