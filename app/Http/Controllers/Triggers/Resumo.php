<?php

namespace App\Http\Controllers\Triggers;

use Telegram\Bot\Keyboard\Keyboard;

class Resumo extends TriggerController
{
    protected $triggers = ['/resumo'];

    protected function run()
    {
        $this->showOptions();
    }

    protected function showOptions()
    {

        $keyboard = [
            Keyboard::inlineButton(['text' => 'Resumir', 'callback_data' => 'resumo:1']),
            Keyboard::inlineButton(['text' => 'Ver o resumo', 'callback_data' => 'resumo:2']),
        ];

        $markup = Keyboard::make([
            'inline_keyboard' => [$keyboard]
        ]);

        $this->telegram->sendMessage([
            'chat_id' => $this->chat->id,
            'text' => 'O que você deseja fazer?',
            'reply_markup' => $markup,
        ]);
    }
}