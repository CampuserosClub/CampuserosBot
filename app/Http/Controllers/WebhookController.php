<?php

namespace App\Http\Controllers;

use App\Support\Telegram\BaseController as Telegram;

class WebhookController extends Telegram
{
    /**
     * @var array
     */
    protected $triggers = [
        \App\Support\Triggers\Grito::class,
        \App\Support\Triggers\Pizza::class,
        \App\Support\Triggers\Treta::class,
        \App\Support\Triggers\Cafe::class,
        \App\Support\Triggers\Proximo::class,
        \App\Support\Triggers\Sexta::class,
        \App\Support\Triggers\Tonico::class,
        \App\Support\Triggers\Pombo::class,
        \App\Support\Triggers\LinkGrupoTelegram::class,
        \App\Support\Triggers\LinkGrupoFacebook::class,
    ];

    public function handle()
    {
        if (!is_null($this->chat)) {
            foreach ($this->triggers as $trigger) {
                new $trigger($this->telegram);
            }
        }
    }
}
