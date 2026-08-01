<?php

namespace App\Core\Telegram;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    private string $token;
    private string $baseUrl;

    public function __construct()
    {
        $this->token = config('services.telegram.bot_token');
        $this->baseUrl = "https://api.telegram.org/bot{$this->token}";
    }

    /*
    |--------------------------------------------------------------------------
    | Universal Request
    |--------------------------------------------------------------------------
    */

    public function request(string $method, array $data = []): ?array
    {
        try {

            $response = Http::timeout(60)
                ->post($this->baseUrl.'/'.$method, $data);

            if (!$response->successful()) {

                Log::error('Telegram API Error', [
                    'method' => $method,
                    'body' => $response->body(),
                ]);

                return null;
            }

            return $response->json();

        } catch (\Throwable $e) {

            Log::error('Telegram Exception', [
                'method' => $method,
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Send Message
    |--------------------------------------------------------------------------
    */

    public function sendMessage(
        int|string $chatId,
        string $text,
        string $parseMode = 'HTML'
    ): ?array {

        return $this->request('sendMessage', [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => $parseMode,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Typing...
    |--------------------------------------------------------------------------
    */

    public function typing(int|string $chatId): ?array
    {
        return $this->request('sendChatAction', [
            'chat_id' => $chatId,
            'action' => 'typing',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Upload Photo
    |--------------------------------------------------------------------------
    */

    public function sendPhoto(
        int|string $chatId,
        string $photo,
        ?string $caption = null
    ): ?array {

        return $this->request('sendPhoto', [
            'chat_id' => $chatId,
            'photo' => $photo,
            'caption' => $caption,
            'parse_mode' => 'HTML',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Upload Video
    |--------------------------------------------------------------------------
    */

    public function sendVideo(
        int|string $chatId,
        string $video,
        ?string $caption = null
    ): ?array {

        return $this->request('sendVideo', [
            'chat_id' => $chatId,
            'video' => $video,
            'caption' => $caption,
            'parse_mode' => 'HTML',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Voice
    |--------------------------------------------------------------------------
    */

    public function sendVoice(
        int|string $chatId,
        string $voice,
        ?string $caption = null
    ): ?array {

        return $this->request('sendVoice', [
            'chat_id' => $chatId,
            'voice' => $voice,
            'caption' => $caption,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Audio
    |--------------------------------------------------------------------------
    */

    public function sendAudio(
        int|string $chatId,
        string $audio
    ): ?array {

        return $this->request('sendAudio', [
            'chat_id' => $chatId,
            'audio' => $audio,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Sticker
    |--------------------------------------------------------------------------
    */

    public function sendSticker(
        int|string $chatId,
        string $sticker
    ): ?array {

        return $this->request('sendSticker', [
            'chat_id' => $chatId,
            'sticker' => $sticker,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | GIF
    |--------------------------------------------------------------------------
    */

    public function sendAnimation(
        int|string $chatId,
        string $animation,
        ?string $caption = null
    ): ?array {

        return $this->request('sendAnimation', [
            'chat_id' => $chatId,
            'animation' => $animation,
            'caption' => $caption,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Document
    |--------------------------------------------------------------------------
    */

    public function sendDocument(
        int|string $chatId,
        string $document
    ): ?array {

        return $this->request('sendDocument', [
            'chat_id' => $chatId,
            'document' => $document,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Message
    |--------------------------------------------------------------------------
    */

    public function editMessage(
        int|string $chatId,
        int $messageId,
        string $text
    ): ?array {

        return $this->request('editMessageText', [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Message
    |--------------------------------------------------------------------------
    */

    public function deleteMessage(
        int|string $chatId,
        int $messageId
    ): ?array {

        return $this->request('deleteMessage', [
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Callback
    |--------------------------------------------------------------------------
    */

    public function answerCallback(
        string $callbackId,
        string $text = ''
    ): ?array {

        return $this->request('answerCallbackQuery', [
            'callback_query_id' => $callbackId,
            'text' => $text,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Get File
    |--------------------------------------------------------------------------
    */

    public function getFile(string $fileId): ?array
    {
        return $this->request('getFile', [
            'file_id' => $fileId,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Download File
    |--------------------------------------------------------------------------
    */

    public function download(string $filePath): ?string
    {
        $url = "https://api.telegram.org/file/bot{$this->token}/{$filePath}";

        try {

            return Http::timeout(60)->get($url)->body();

        } catch (\Throwable $e) {

            Log::error($e->getMessage());

            return null;
        }
    }
}