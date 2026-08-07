<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramUser extends Model
{
    protected $fillable = [
        'telegram_id',
        'username',
        'first_name',
        'last_name',
        'language_code',
        'is_bot',
        'last_seen_at',
    ];

    protected $casts = [
        'is_bot' => 'boolean',
        'last_seen_at' => 'datetime',
    ];
}