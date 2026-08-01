<?php

namespace App\Core\DTO;

class UpdateData
{
    public function __construct(
        public readonly string $type,

        public readonly int|string|null $chatId = null,

        public readonly int|string|null $userId = null,

        public readonly ?int $messageId = null,

        public readonly ?string $text = null,

        public readonly ?string $caption = null,

        public readonly ?string $fileId = null,

        public readonly ?string $fileType = null,

        public readonly ?string $username = null,

        public readonly ?string $firstName = null,

        public readonly ?string $lastName = null,

        public readonly ?string $languageCode = null,

        public readonly array $raw = [],
    ) {}
}