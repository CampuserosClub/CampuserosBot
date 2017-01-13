<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TelegramUser extends Model
{
    protected $fillable = ['user_id', 'messages', 'blocked', 'times_blocked', 'last_message'];

    protected $dates = ['last_message'];
}
