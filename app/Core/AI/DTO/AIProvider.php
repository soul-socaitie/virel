<?php

namespace App\Core\AI\Contracts;

use App\Core\AI\DTO\AIRequest;
use App\Core\AI\DTO\AIResponse;

interface AIProvider
{
    public function chat(
        AIRequest $request
    ): AIResponse;
}
