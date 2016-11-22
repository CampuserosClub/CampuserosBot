<?php

namespace CampuserosBot\Http\Controllers;

use CampuserosBot\Support\Telegram\BaseController as Telegram;

class WebhookController extends Telegram
{
    /**
     * @var array
     */
    protected $triggers = [
        \CampuserosBot\Support\Triggers\Grito::class,
        \CampuserosBot\Support\Triggers\Pizza::class,
        \CampuserosBot\Support\Triggers\Treta::class,
        \CampuserosBot\Support\Triggers\Cafe::class,
        \CampuserosBot\Support\Triggers\Proximo::class,
        \CampuserosBot\Support\Triggers\Sexta::class,
        \CampuserosBot\Support\Triggers\Tonico::class,
        \CampuserosBot\Support\Triggers\Pombo::class,
        \CampuserosBot\Support\Triggers\LinkGrupoTelegram::class,
        \CampuserosBot\Support\Triggers\LinkGrupoFacebook::class,
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
