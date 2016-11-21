<?php

namespace App\Support\Triggers;

class LinkGrupoFacebook extends Trigger
{
    protected $triggers = [
        '/linkgrupofacebook',
    ];

    protected $responses = [
        'Voilà! https://www.facebook.com/groups/campuserosinternationalclub/',
    ];
}
