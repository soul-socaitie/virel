<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramWebhookController;

Route::post('/telegram/webhook/{secret}', TelegramWebhookController::class);

Route::get('/', function () {
    return view('welcome');
});
