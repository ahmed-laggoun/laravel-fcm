<?php

namespace SmirlTech\LaravelFcm\Messages;

use SmirlTech\LaravelFcm\Facades\LaravelFcm;

class FirebaseMessage
{
    const PRIORITY_NORMAL = 'normal';

    private string $title;

    private string $body;

    private string $clickAction;

    private string $image;

    private string $icon;

    private string $sound;

    private string $additionalData;

    private string $priority = self::PRIORITY_NORMAL;

    private string $fromArray;

    public function withTitle($title): static
    {
        $this->title = $title;

        return $this;
    }

    public function withBody($body): static
    {
        $this->body = $body;

        return $this;
    }

    public function withClickAction($clickAction): static
    {
        $this->clickAction = $clickAction;

        return $this;
    }

    public function withImage($image): static
    {
        $this->image = $image;

        return $this;
    }

    public function withIcon($icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function withSound($sound): static
    {
        $this->sound = $sound;

        return $this;
    }

    public function withAdditionalData($additionalData): static
    {
        $this->additionalData = $additionalData;

        return $this;
    }

    public function withPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    public function fromArray($fromArray)
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
