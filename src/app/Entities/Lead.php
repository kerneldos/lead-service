<?php

namespace App\Entities;

/**
 * Модель лида
 */
class Lead
{
    public function __construct(
        public readonly ?int       $id,
        private readonly int       $channelId,
        private readonly array     $data,
        private readonly bool      $isFull,
        private ?\DateTime         $processedAt,
        private readonly \DateTime $createdAt
    ) {}

    public function getId(): ?int { return $this->id; }
    public function getChannelId(): int { return $this->channelId; }
    public function getData(): array { return $this->data; }
    public function isFull(): bool { return $this->isFull; }
    public function getProcessedAt(): ?\DateTime { return $this->processedAt; }
    public function getCreatedAt(): \DateTime { return $this->createdAt; }

    public function markAsProcessed(): void
    {
        $this->processedAt = new \DateTime();
    }
}
