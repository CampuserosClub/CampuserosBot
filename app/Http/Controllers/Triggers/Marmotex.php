<?php

namespace App\Http\Controllers\Triggers;

class Marmotex extends Trigger
{
    protected $triggers = [
        'comida',
        'food',
        'marmotex',
        'almoço',
        'almoçar',
        'janta',
        'jantar',
        'catering',
        'alimentação'
    ];

    protected function customReply()
    {
        $text = "Que tal comprar comida de restaurante com o preço de quentinha? 😋\n\n";
        $text .= "Acesse o link e compre Marmotex \n";
        $text .= "https://goo.gl/lPMM1p\n\n";
        $text .= "Não esqueça de utilizar nosso código: *MARMOTACLUB*\n";

        $this->bot->reply($text, [
            'parse_mode' => 'markdown'
        ]);
    }
}