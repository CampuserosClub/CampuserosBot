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
                $this->telegram->sendMessage([
                    'chat_id' => $this->chat->id,
                    'text' => $this->resumoToday(),
                    'parse_mode' => 'markdown'
                ]);
            } else {
                $campuserosclub = str_is($this->chat->username, 'CampuserosClub');
                $beta = str_is($this->chat->username, 'jaoNoctus');

                if ($campuserosclub or $beta) {
                    $text = collect(explode('/res', $text))->last();
                    $text = $this->sanitizeText($text);

                    $this->storeResumo($text);
                } else {
                    $this->telegram->sendMessage([
                        'chat_id' => $this->chat->id,
                        'text' => 'Esse comando só pode ser usado no grupo @CampuserosClub',
                    ]);
                }

            }
        }
    }

    protected function resumoToday()
    {
        $resumos = \App\Resumo::today()->get();

        $txt = "#RESUMO *" . \Carbon\Carbon::now()->format('d/m/Y') . "*\n\n";

        if (collect($resumos)->isEmpty()) {
            $txt .= '[nenhuma anotação encontrada]';
        } else {
            foreach ($resumos as $resumo) {
                $hour = $resumo->created_at->format('H:i');
                $txt .= "*[ $hour ]* " . $resumo->text . "\n";
            }
        }

        return $txt;
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
                'text' => 'Ver o resumo',
                'url' => 'https://t.me/'.$me.'?start=resumo:parcial'
            ]),
        ];

        $markup = Keyboard::make([
            'inline_keyboard' => [$keyboard]
        ]);

        $this->telegram->sendMessage([
            'chat_id' => $this->chat->id,
            'text' => "*O que você deseja fazer?*\n\n_para resumir, use:_\n`/res` `{escreva aqui}`",
            'parse_mode' => 'markdown',
            'reply_markup' => $markup,
        ]);
    }

    /**
     * Sanitize text.
     *
     * @param $text
     * @return string
     */
    protected function sanitizeText($text)
    {
        $text = str_replace(' {escreva aqui}', '', $text);
        $text = str_replace('{', '', $text);
        $text = str_replace('}', '', $text);

        return $text;
    }

    protected function storeResumo($text)
    {
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
    }
}