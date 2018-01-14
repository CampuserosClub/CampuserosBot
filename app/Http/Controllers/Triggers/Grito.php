<?php

namespace App\Http\Controllers\Triggers;

class Grito extends Trigger
{
    protected $triggers = ['ooo'];

    protected $texts = [
        'OooOOOOOOOoooOoooooo',
        'ooooooOOOOOoooOOOOooooo',
        'oooooooOOOOOOOOoooooO',
        'OooOOOOOOOoooo',
        'OoooOoooOoOOO'
    ];
}