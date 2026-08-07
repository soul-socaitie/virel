<?php

namespace App\Http\Controllers;

use App\Core\Telegram\TelegramService;
use Illuminate\Http\Request;
use App\Core\Bot\BotService;

class TelegramWebhookController extends Controller
{
public function __invoke(
    Request $request,
    string $secret,
    BotService $bot
    ) {

    if ($secret !== config('services.telegram.secret')) {
        abort(403);
    }

    $bot->handle($request->all());

    return response()->json([
        'ok' => true
    ]);
}
}