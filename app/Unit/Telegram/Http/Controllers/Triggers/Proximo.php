<?php

namespace CampuserosBot\Unit\Telegram\Http\Controllers\Triggers;

class Proximo extends Trigger
{
    protected $triggers = [
        'proximo',
        'próximo',
    ];

    protected $returns = [
        ['type' => 1, 'return' => 'BQADAQADEAEAAm-8_wKeTmVwt36EGAI'],
    ];
}
