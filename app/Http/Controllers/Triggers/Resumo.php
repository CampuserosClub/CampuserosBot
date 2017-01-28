<?php

namespace App\Http\Controllers\Triggers;

use Telegram\Bot\Keyboard\Keyboard;

class Resumo extends TriggerController
{
    protected $triggers = ['/resumo', '/start resumo:parcial', '/res'];

    protected function run()
    {
        $text = $this->message->text;

        if (starts_with($text, '/resumo')) {
            $this->showOptions();
        } else {
            if (str_is('/start resumo:parcial', $text)) {
                $resumos = \App\Resumo::today()->get();

                $txt = "#RESUMO (parcial) *" . \Carbon\Carbon::now()->format('d/m/Y') . "*\n\n";

                foreach ($resumos as $resumo) {
                    $hour = $resumo->created_at->format('H:i');
                    $txt .= "*[ $hour ]* " . $resumo->text . "\n";
                }

                $this->telegram->sendMessage([
                    'chat_id' => $this->chat->id,
                    'text' => $txt,
                    'parse_mode' => 'markdown'
                ]);

            } else {

                if (str_is($this->chat->username, 'CampuserosClub')) {
                    $text = collect(explode('/res', $text))->last();
                    $text = str_replace(' {escreva aqui}', '', $text);

                    if (!empty($text)) {
                        $by = $this->message->from->id;

                        \App\Resumo::create([
                            'text' => $text,
                            'by' => $by,
                        ]);

                        $this->telegram->sendMessage([
                            'chat_id' => $this->chat->id,
                            'text' => 'Anotado ;)',
                        ]);
                    }

                } else {
                    $this->telegram->sendMessage([
                        'chat_id' => $this->chat->id,
                        'text' => 'Esse comando só pode ser usado no grupo @CampuserosClub',
                    ]);
                }

            }
        }
    }

    protected function showOptions()
    {
        $me = $this->telegram->getMe()->username;
        $keyboard = [
            Keyboard::inlineButton([
                'text' => 'Resumir',
                'switch_inline_query_current_chat' => '/res {escreva aqui}'
            ]),
            Keyboard::inlineButton([
                'text' => 'Ver o resumo parcial de hoje',
                'url' => 'https://t.me/'.$me.'?start=resumo:parcial'
            ]),
        ];

        $markup = Keyboard::make([
            'inline_keyboard' => [$keyboard]
        ]);

        $this->telegram->sendMessage([
            'chat_id' => $this->chat->id,
            'text' => "O que você deseja fazer?",
            'reply_markup' => $markup,
        ]);
    }
}