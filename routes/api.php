<?php

use App\Http\Controllers\Api\ChatbotController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/chatbot/send', [ChatbotController::class, 'sendMessage'])
    ->name('api.chatbot.send');