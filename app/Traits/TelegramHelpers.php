<?php

namespace App\Traits;

use Telegram\Bot\Api;

trait TelegramHelpers
{
    protected function getDocumentId(Api $telegram, $chat_id = null)
    {
        $updates = $telegram->getWebhookUpdate();
        $message = $updates->message;
        $chat = $message->chat;
        $document = $message->document;
        $file_id = $document->fileId;

        $chat_id = is_null($chat_id) ? $chat->getId() : $chat_id;

        $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => (string) $file_id,
        ]);
    }
}