<?php

namespace CampuserosBot\Unit\Telegram\Http\Controllers\Triggers;

class Grito extends Trigger
{
    protected $triggers = [
        'ooo',
    ];

    protected $responses = [
        'OooOOOOOOOoooOoooooo',
        'ooooooOOOOOoooOOOOooooo',
        'oooooooOOOOOOOOoooooO',
        'OooOOOOOOOoooo',
        'OoooOoooOoOOO',
    ];

    protected $returns = [
        ['type' => 0, 'return' => 'OooOOOOOOOoooOoooooo'],
        ['type' => 0, 'return' => 'ooooooOOOOOoooOOOOooooo'],
        ['type' => 0, 'return' => 'oooooooOOOOOOOOoooooO'],
        ['type' => 0, 'return' => 'OooOOOOOOOoooo'],
        ['type' => 0, 'return' => 'OoooOoooOoOOO'],
    ];
}
