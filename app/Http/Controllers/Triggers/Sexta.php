<?php

namespace App\Http\Controllers\Triggers;

class Sexta extends TriggerController
{
    protected $triggers = ['sexta'];

    protected $gifs = [
        'production' => [
            'BQADBAADjCEAAtUXZAeLsHs0N0x2nAI', // party hard girafa
            'BQADAQADDQEAAnOkGAPeLTuJjPoNyAI', // party hard gandalf
        ],
        'local' => [
            'BQADBAADjCEAAtUXZAfiwPcBb3_Q0gI', // party hard girafa
            'BQADAQADDAEAAnOkGANFvZFaSCP3SgI', // party hard gandalf
        ],
    ];
}