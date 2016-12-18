<?php

namespace CampuserosBot\Unit\Telegram\Http\Controllers\Triggers;

class LinkGrupoFacebook extends Trigger
{
    protected $triggers = [
        '/linkgrupofacebook',
    ];

    protected $returns = [
        ['type' => 0, 'return' => 'Voilà! https://www.facebook.com/groups/campuserosinternationalclub/'],
    ];
}
