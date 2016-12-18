<?php

namespace CampuserosBot\Unit\Telegram\Http\Controllers\Triggers;

class LinkGrupoTelegram extends Trigger
{
    protected $triggers = [
        '/linkgrupotelegram',
    ];

    protected $returns = [
        ['type' => 0, 'return' => 'Ooopa! Aqui está: https://telegram.me/CampuserosClub'],
    ];
}
