<?php

namespace CampuserosBot\Unit\Telegram\Http\Controllers\Triggers;

class Pizza extends Trigger
{
    protected $triggers = [
        'pizza',
    ];

    protected $returns = [
        ['type' => 0, 'return' => 'Pizzaaaaaaaaaaaaaaaaaaaaaaaaaaaa'],
        ['type' => 0, 'return' => 'PIZZAAAAAAA'],
        ['type' => 0, 'return' => 'Pizzaaaaaaaaaaaaaaaaaaa!!!'],
        ['type' => 2, 'return' => 'http://i.giphy.com/3o6ZtdOqypaPwQ5nMI.gif'],
    ];
}
