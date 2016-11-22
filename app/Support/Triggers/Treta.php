<?php

namespace CampuserosBot\Support\Triggers;

class Treta extends Trigger
{
    protected $triggers = [
        'biscoito',
        'bolacha',
    ];

    protected function run()
    {
        $responses = collect($this->triggers);
        $text = $this->message->getText();

        $response = 'É ';
        $response .= $this->checkText($text, $responses->first()) ? $responses->last() : $responses->first();

        $this->telegram->sendMessage([
            'chat_id' => $this->chat->getId(),
            'text' => $response,
        ]);
    }
}