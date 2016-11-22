<?php

namespace CampuserosBot\Unit\Telegram\Http\Controllers\Triggers;

class LinkGrupoFacebook extends Trigger
{
    protected $triggers = [
        '/linkgrupofacebook',
    ];

    protected $responses = [
        'Voilà! https://www.facebook.com/groups/campuserosinternationalclub/',
    ];
}