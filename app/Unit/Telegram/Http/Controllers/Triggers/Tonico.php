<?php

namespace CampuserosBot\Unit\Telegram\Http\Controllers\Triggers;

class Tonico extends Trigger
{
    protected $triggers = [
        'tonico',
        'help',
    ];
    
    protected $returns = [
        ['type' => 2, 'return' => 'http://i.giphy.com/srgUMnkzt4esM.gif'],
    ];
}
