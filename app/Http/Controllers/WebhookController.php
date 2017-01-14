<?php

namespace App\Http\Controllers;

class WebhookController extends TelegramController
{
    protected $triggers = [
        \App\Http\Controllers\Triggers\About::class,
        \App\Http\Controllers\Triggers\BiscoitoBolacha::class,
        \App\Http\Controllers\Triggers\Cafe::class,
        \App\Http\Controllers\Triggers\Grito::class,
        \App\Http\Controllers\Triggers\Pizza::class,
        \App\Http\Controllers\Triggers\Pombo::class,
        \App\Http\Controllers\Triggers\Proximo::class,
        \App\Http\Controllers\Triggers\Sexta::class,
        \App\Http\Controllers\Triggers\Tonico::class,
    ];

    public function handle()
    {
        if (!is_null($this->chat)) {
//            $doc = $this->message->getDocument();
//            $doc_id = $doc->getFileId();
//
//            $this->telegram->sendMessage([
//                'chat_id' => $this->chat->getId(),
//                'text' => (string) $doc_id,
//            ]);

            foreach ($this->triggers as $trigger) {
                new $trigger($this->telegram);
            }
        }
    }
}
