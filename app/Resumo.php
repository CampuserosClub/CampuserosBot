<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resumo extends Model
{
    protected $fillable = ['text', 'by'];

    public function scopeToday($query)
    {
        $today = \Carbon\Carbon::now()->format('Y-m-d');
        return $query->where('created_at', 'like', "$today%");
    }
}
