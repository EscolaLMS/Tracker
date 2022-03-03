<?php

namespace EscolaLms\Tracker\Models;

use Illuminate\Database\Eloquent\Model;

class TrackRoute extends Model
{
    protected $fillable = [
        'user_id',
        'path',
        'full_path',
        'method',
        'extra',
    ];
}
