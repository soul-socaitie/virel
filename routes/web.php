<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramWebhookController;
use App\Core\AI\AIService;
use App\Core\AI\DTO\AIMessage;
use App\Core\AI\DTO\AIRequest;

Route::post('/telegram/webhook/{secret}', TelegramWebhookController::class);

Route::get('/test-ai', function (AIService $ai) {

    $response = $ai->chat(
        new AIRequest(
            messages: [
                new AIMessage(
                    role: 'user',
                    content: "Salom, o'zingni tanishtir."
                )
            ]
        )
    );

    return response()->json($response);
});

Route::get('/', function () {
    return view('welcome');
});