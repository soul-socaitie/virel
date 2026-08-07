<?php

namespace App\Core\AI\DTO;

class AIRequest
{
    /**
     * @param AIMessage[] $messages
     * @param array $tools
     */
    public function __construct(
        public readonly array $messages,
        public readonly string $model = 'gpt-5.5',
        public readonly float $temperature = 0.8,
        public readonly array $tools = [],
    ) {
    }

    public function messages(): array
    {
        return array_map(
            fn (AIMessage $message) => $message->toArray(),
            $this->messages
        );
    }
}