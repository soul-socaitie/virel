<?php

namespace App\Core\Bot;

use App\Core\Parser\UpdateParser;
use App\Core\Telegram\TelegramService;

class BotService
{
    public function __construct(
        protected UpdateParser $parser,
        protected TelegramService $telegram,
    ) {
    }

    public function handle(array $update): void
    {
        $update = $this->parser->parse($update);

        if ($update->chatId === null) {
            return;
        }

        $this->telegram->typing($update->chatId);

        $this->telegram->sendMessage(
            $update->chatId,
            "🤖 Virel AI ishga tushdi!\n\nSiz yozdingiz:\n{$update->text}"
        );
    }
}