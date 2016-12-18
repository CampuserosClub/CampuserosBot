<?php

namespace CampuserosBot\Unit\Telegram\Http\Controllers\Triggers;

class Cafe extends Trigger
{
    protected $triggers = [
        'cafe',
        'café',
    ];

    protected $returns = [
        ['type' => 1, 'return' => 'BQADAQADigADc6QYA5uQxxPZmMZGAg'],
        ['type' => 1, 'return' => 'BQADAQADYQADC1TfAAHnb5n94sar6AI'],
        ['type' => 1, 'return' => 'BQADAgADgAADGgZFBBPEOyAbYERuAg'],
        ['type' => 1, 'return' => 'BQADAQADVgEAAtpxZgdD4Q1UGK41qgI'],
    ];
}
