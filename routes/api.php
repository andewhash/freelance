<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::any('/ai/generate', function(Request $request) {
    $prompt = $request->input('prompt');

    if (!$prompt) {
        return response()->json(['error' => 'Введите текст'], 422);
    }

    try {
        // Устанавливаем таймаут 30 секунд для HTTP-запроса
        $response = Http::timeout(30)->withHeaders([
            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY', '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'),
            'Content-Type' => 'application/json'
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
             'model' => 'deepseek/deepseek-chat-v3-0324:free',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ]
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'API error', 'details' => $response->json()], 500);
        }

        return response()->json([
            'reply' => $response->json('choices.0.message.content')
        ]);

    } catch (\Illuminate\Http\Client\ConnectionException $e) {
        // Таймаут соединения
        return response()->json([
            'error' => 'Нейросеть сейчас перегружена, пожалуйста, подождите немного и попробуйте снова'
        ], 504); // 504 Gateway Timeout
        
    } catch (\Exception $e) {
        // Другие ошибки
        return response()->json([
            'error' => 'Произошла ошибка при генерации текста',
            'details' => $e->getMessage()
        ], 500);
    }
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
