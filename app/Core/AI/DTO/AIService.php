<?php

namespace App\Core\AI;

use App\Core\AI\Contracts\AIProvider;
use App\Core\AI\DTO\AIRequest;
use App\Core\AI\DTO\AIResponse;

class AIService
{
    public function __construct(
        protected AIProvider $provider
    ) {
    }

    public function chat(AIRequest $request): AIResponse
    {
        return $this->provider->chat($request);
    }
}