<?php

namespace EscolaLms\Tracker\Models;

use EscolaLms\Core\Models\User;
use EscolaLms\Tracker\Database\Factories\TrackRouteFactory;
use EscolaLms\Tracker\Facades\Tracker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function getConnectionName(): ?string
    {
        return Tracker::getConnection() ?? $this->connection;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory(): TrackRouteFactory
    {
        return TrackRouteFactory::new();
    }
}
