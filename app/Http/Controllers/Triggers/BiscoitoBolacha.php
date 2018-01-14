<?php

namespace App\Http\Controllers\Triggers;

class BiscoitoBolacha extends Trigger
{
    protected $triggers = ['biscoito', 'bolacha'];

    protected function customReply()
    {
        $responses = collect($this->triggers);

        $response = 'É ';
        $response .= $this->checkText($this->message, $responses->first())
            ? $responses->last()
            : $responses->first();

        $this->bot->reply($response);
    }
}