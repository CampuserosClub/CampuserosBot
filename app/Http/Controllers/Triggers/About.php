<?php

namespace App\Http\Controllers\Triggers;

class About extends TriggerController
{
    protected $triggers = [
        '/about',
    ];

    protected function run()
    {
        $text = "";
        $text .= "*GitHub* [fork me](https://github.com/CampuserosClub/CampuserosBot)";

        $this->telegram->sendMessage([
            'chat_id' => $this->chat->id,
            'text' => $text,
            'parse_mode' => 'markdown',
            'disable_web_page_preview' => true,
        ]);
    }
}