<?php

namespace App\Core\AI\Providers;

use App\Core\AI\Contracts\AIProvider;
use App\Core\AI\DTO\AIMessage;
use App\Core\AI\DTO\AIRequest;
use App\Core\AI\DTO\AIResponse;
use App\Core\AI\Prompts\SystemPrompt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenRouterProvider implements AIProvider
{
    protected string $apiKey;

    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('services.openrouter.api_key');
        $this->model = config('services.openrouter.model');
    }

    public function chat(AIRequest $request): AIResponse
    {
        $messages = [
            new AIMessage(
                role: 'system',
                content: SystemPrompt::text(),
            ),
            ...$request->messages,
        ];

        $response = Http::timeout(60)
            ->withHeaders([
                'Authorization' => 'Bearer '.$this->apiKey,
                'Content-Type' => 'application/json',
                'HTTP-Referer' => config('app.url'),
                'X-Title' => config('app.name'),
            ])
            ->post(
                'https://openrouter.ai/api/v1/chat/completions',
                [
                    'model' => $this->model,
                    'messages' => array_map(
                        fn (AIMessage $message) => $message->toArray(),
                        $messages
                    ),
                    'temperature' => $request->temperature,
                ]
            );

        if (! $response->successful()) {

            Log::error('OpenRouter Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new \RuntimeException(
                'OpenRouter API Error'
            );
        }

        $json = $response->json();

        return new AIResponse(
            reply: trim(
                $json['choices'][0]['message']['content'] ?? ''
            )
        );
    }
}