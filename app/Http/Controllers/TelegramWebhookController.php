<?php

namespace App\Http\Controllers;

use App\Core\Telegram\TelegramService;
use Illuminate\Http\Request;

class TelegramWebhookController extends Controller
{
    public function __invoke(
    Request $request,
    string $secret,
    TelegramService $telegram
) {
    if ($secret !== config('services.telegram.secret')) {
        abort(403);
    }

    $chatId = data_get($request->all(), 'message.chat.id');
    $text = data_get($request->all(), 'message.text');

    if ($chatId && $text) {
        $telegram->typing($chatId);

        $telegram->sendMessage(
            $chatId,
            "Test ishladi ✅\n\n$text"
        );
    }

    return response()->json([
        'ok' => true,
    ]);
}
}