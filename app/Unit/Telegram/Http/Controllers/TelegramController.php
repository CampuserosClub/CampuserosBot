<?php

namespace CampuserosBot\Unit\Telegram\Http\Controllers;

use CampuserosBot\Core\Unit\Http\TelegramController as Telegram;

class TelegramController extends Telegram
{
    protected $triggers = [
        \CampuserosBot\Unit\Telegram\Http\Controllers\Triggers\Cafe::class,
        \CampuserosBot\Unit\Telegram\Http\Controllers\Triggers\Grito::class,
        \CampuserosBot\Unit\Telegram\Http\Controllers\Triggers\LinkGrupoFacebook::class,
        \CampuserosBot\Unit\Telegram\Http\Controllers\Triggers\LinkGrupoTelegram::class,
        \CampuserosBot\Unit\Telegram\Http\Controllers\Triggers\Pizza::class,
        \CampuserosBot\Unit\Telegram\Http\Controllers\Triggers\Pombo::class,
        \CampuserosBot\Unit\Telegram\Http\Controllers\Triggers\Proximo::class,
        \CampuserosBot\Unit\Telegram\Http\Controllers\Triggers\Sexta::class,
        \CampuserosBot\Unit\Telegram\Http\Controllers\Triggers\Tonico::class,
        \CampuserosBot\Unit\Telegram\Http\Controllers\Triggers\BiscoitoBolacha::class,
        \CampuserosBot\Unit\Telegram\Http\Controllers\Triggers\Countdown::class,
        \CampuserosBot\Unit\Telegram\Http\Controllers\Triggers\Thegame::class,
        \CampuserosBot\Unit\Telegram\Http\Controllers\Triggers\Regrasthegame::class,
    ];

    public function webhook()
    {
        if (!is_null($this->chat)) {
            foreach ($this->triggers as $trigger) {
                new $trigger($this->telegram);
            }
        }
    }
}
