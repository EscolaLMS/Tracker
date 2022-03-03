<?php

namespace EscolaLms\Tracker\Models;

use EscolaLms\Tracker\Database\Factories\TrackRouteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackRoute extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'path',
        'full_path',
        'method',
        'extra',
    ];

    protected $casts = [
        'extra' => 'array'
    ];

    public function getConnectionName()
    {
        return config('escolalms_tracker.database.connection') ?? $this->connection;
    }

    protected static function newFactory(): TrackRouteFactory
    {
        return TrackRouteFactory::new();
    }
}
