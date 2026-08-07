<?php

namespace App\Core\AI\DTO;

class AIMessage
{
    public function __construct(
        public readonly string $role,
        public readonly string $content,
    ) {
    }

    public function toArray(): array
    {
        return [
            'role' => $this->role,
            'content' => $this->content,
        ];
    }
}