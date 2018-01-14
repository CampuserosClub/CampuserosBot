<?php

namespace App\Http\Controllers\Triggers;

class About extends Trigger
{
    protected $triggers = [
        '/about'
    ];

    protected function customReply()
    {
        $text = "Sou um bot de software livre 😜\n";
        $text .= "Desenvolvido por @jaonoctus\n";
        $text .= "https://github.com/CampuserosClub/CampuserosBot";

        $this->bot->reply($text, [
            'parse_mode' => 'markdown',
            'disable_web_page_preview' => true,
        ]);
    }
}