<?php

namespace App\Core\User;

use App\Core\DTO\UpdateData;
use App\Models\TelegramUser;

class UserService
{
    public function resolve(UpdateData $update): TelegramUser
    {
        return TelegramUser::updateOrCreate(
            [
                'telegram_id' => $update->userId,
            ],
            [
                'username' => $update->username,
                'first_name' => $update->firstName ?? '',
                'last_name' => $update->lastName,
                'language_code' => $update->languageCode,
                'last_seen_at' => now(),
            ]
        );
    }
}