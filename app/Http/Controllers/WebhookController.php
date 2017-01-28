<?php

namespace App\Http\Controllers;

use App\Traits\TelegramHelpers;

class WebhookController extends TelegramController
{
    use TelegramHelpers;

    protected $triggers = [
        \App\Http\Controllers\Triggers\About::class,
        \App\Http\Controllers\Triggers\BiscoitoBolacha::class,
        \App\Http\Controllers\Triggers\Cafe::class,
        \App\Http\Controllers\Triggers\Gas::class,
        \App\Http\Controllers\Triggers\Grito::class,
        \App\Http\Controllers\Triggers\Pizza::class,
        \App\Http\Controllers\Triggers\Pombo::class,
        \App\Http\Controllers\Triggers\Proximo::class,
        \App\Http\Controllers\Triggers\Sexta::class,
        \App\Http\Controllers\Triggers\Tonico::class,
        \App\Http\Controllers\Triggers\Resumo::class,
//        \App\Http\Controllers\Triggers\VoteBan::class,
    ];

    public function handle()
    {
        switch ($this->update->detectType()) {
            case 'message':
                $this->triggers();
                break;
            case 'callback_query':
                $this->callbacks();
                break;
        }
    }

    protected function triggers()
    {
        foreach ($this->triggers as $trigger) {
            new $trigger($this->telegram);
        }
    }

    protected function callbacks()
    {
        \Log::info($this->update->callbackQuery->data);
    }
}
