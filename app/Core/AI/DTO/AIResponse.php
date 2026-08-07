<?php

namespace App\Core\AI\DTO;

class AIResponse
{
    public function __construct(
        public readonly string $reply,

        public readonly ?string $emotion = null,

        public readonly ?string $tool = null,

        public readonly array $toolPayload = [],

        public readonly array $metadata = [],
    ) {
    }
}   