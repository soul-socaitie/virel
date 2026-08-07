<?php

namespace App\Core\AI\Providers;

use App\Core\AI\Contracts\AIProvider;
use App\Core\AI\DTO\AIRequest;
use App\Core\AI\DTO\AIResponse;
use Illuminate\Support\Facades\Http;

class OpenAIProvider implements AIProvider
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
    }

    public function chat(AIRequest $request): AIResponse
    {
        $response = Http::withToken($this->apiKey)
            ->acceptJson()
            ->post('https://api.openai.com/v1/responses', [
                'model' => $request->model,
                'input' => $request->messages(),
                'temperature' => $request->temperature,
            ]);

        if (! $response->successful()) {
            throw new \RuntimeException(
                'OpenAI API Error: '.$response->body()
            );
        }

        $json = $response->json();

        return new AIResponse(
            reply: $json['output'][0]['content'][0]['text'] ?? ''
        );
    }
}