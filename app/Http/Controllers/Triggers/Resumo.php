<?php

namespace App\Http\Controllers\Triggers;

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
            [
                'text' => 'Resumir',
                'callback_data' => 'a',
            ],
            [
                'text' => 'Ver o resumo',
                'callback_data' => 'b',
            ],
        ];

        $markup = $this->telegram->inlineKeyboardMarkup($keyboard);

        $message = $this->telegram->sendMessage([
            'chat_id' => $this->chat->getId(),
            'text' => 'O que você deseja fazer?',
            'reply_markup' => $markup,
        ]);
    }
}