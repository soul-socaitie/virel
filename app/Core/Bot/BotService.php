<?php

namespace App\Core\Bot;

use App\Core\Parser\UpdateParser;
use App\Core\Telegram\TelegramService;
use App\Core\User\UserService;
use App\Core\AI\AIService;


class BotService
{
    public function __construct(
        protected AIService $ai,
        protected UpdateParser $parser,
        protected UserService $users,
        protected TelegramService $telegram,
    ) {
    }

    public function handle(array $update): void
{
    $update = $this->parser->parse($update);

    $this->users->resolve($update);

    if ($update->chatId === null) {
        return;
    }

    $this->telegram->typing($update->chatId);
    $response = $this->ai->chat(
        new \App\Core\AI\DTO\AIRequest(
            messages: [
                new \App\Core\AI\DTO\AIMessage(
                    role: 'user',
                    content: $update->text ?? ''
                    )
                ]
            )
        );

        $this->telegram->sendMessage(
         $update->chatId,
         $response->reply
        );
    }
}