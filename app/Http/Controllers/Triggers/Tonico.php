<?php

namespace App\Http\Controllers\Triggers;

class Tonico extends TriggerController
{
    protected $triggers = ['tonico', 'help'];

    protected $gifs = [
        'production' => [
            'BQADAQADDwEAAnOkGAOIa_CTv1FOggI'
        ],
        'local' => [
            'BQADAQADCgEAAnOkGAN02gwNM58Z3AI',
        ],
    ];
}