<?php

namespace App\Core\AI\Providers;

use App\Core\AI\Contracts\AIProvider;
use App\Core\AI\DTO\AIMessage;
use App\Core\AI\DTO\AIRequest;
use App\Core\AI\DTO\AIResponse;
use App\Core\AI\Prompts\SystemPrompt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class OpenAIProvider implements AIProvider
{
    protected string $apiKey;

    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
        $this->model = config('services.openai.model');
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
            ->withToken($this->apiKey)
            ->acceptJson()
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => $this->model,
                'messages' => array_map(
                    fn (AIMessage $message) => $message->toArray(),
                    $messages
                ),
                'temperature' => $request->temperature,
            ]);

        if (! $response->successful()) {

            Log::error('OpenAI Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new \RuntimeException(
                'OpenAI API Error'
            );
        }

        $json = $response->json();

        return new AIResponse(
            reply: $json['choices'][0]['message']['content'] ?? ''
        );
    }
}