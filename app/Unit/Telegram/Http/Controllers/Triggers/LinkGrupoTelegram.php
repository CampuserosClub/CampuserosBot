<?php

namespace CampuserosBot\Unit\Telegram\Http\Controllers\Triggers;

class LinkGrupoTelegram extends Trigger
{
    protected $triggers = [
        '/linkgrupotelegram',
    ];

    protected $responses = [
        'Ooopa! Aqui está: https://telegram.me/CampuserosClub',
    ];
}