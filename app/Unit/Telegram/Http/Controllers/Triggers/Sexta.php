<?php

namespace CampuserosBot\Unit\Telegram\Http\Controllers\Triggers;

class Sexta extends Trigger
{
    protected $triggers = [
        'sexta',
    ];

    protected $returns = [
        ['type' => 2, 'return' => 'http://i.giphy.com/5uLOzZipGuz3G.gif'],
    ];
}
