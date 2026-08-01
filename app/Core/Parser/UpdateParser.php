<?php

namespace App\Core\Parser;

use App\Core\DTO\UpdateData;

class UpdateParser
{
    public function parse(array $update): UpdateData
    {
        $message = $update['message'] ?? [];

        return new UpdateData(
            type: $this->detectType($message),

            chatId: $message['chat']['id'] ?? null,

            userId: $message['from']['id'] ?? null,

            messageId: $message['message_id'] ?? null,

            text: $message['text'] ?? null,

            caption: $message['caption'] ?? null,

            fileId: $this->detectFileId($message),

            fileType: $this->detectFileType($message),

            username: $message['from']['username'] ?? null,

            firstName: $message['from']['first_name'] ?? null,

            lastName: $message['from']['last_name'] ?? null,

            languageCode: $message['from']['language_code'] ?? null,

            raw: $update,
        );
    }

    protected function detectType(array $message): string
    {
        if (isset($message['text'])) {
            return 'text';
        }

        if (isset($message['photo'])) {
            return 'photo';
        }

        if (isset($message['video'])) {
            return 'video';
        }

        if (isset($message['voice'])) {
            return 'voice';
        }

        if (isset($message['audio'])) {
            return 'audio';
        }

        if (isset($message['document'])) {
            return 'document';
        }

        if (isset($message['sticker'])) {
            return 'sticker';
        }

        if (isset($message['animation'])) {
            return 'animation';
        }

        return 'unknown';
    }

    protected function detectFileId(array $message): ?string
    {
        if (isset($message['photo'])) {
            return end($message['photo'])['file_id'];
        }

        foreach ([
            'video',
            'voice',
            'audio',
            'document',
            'sticker',
            'animation',
        ] as $type) {

            if (isset($message[$type])) {
                return $message[$type]['file_id'];
            }
        }

        return null;
    }

    protected function detectFileType(array $message): ?string
    {
        foreach ([
            'photo',
            'video',
            'voice',
            'audio',
            'document',
            'sticker',
            'animation',
        ] as $type) {

            if (isset($message[$type])) {
                return $type;
            }
        }

        return null;
    }
}