<?php

namespace EscolaLms\Tracker\Models;

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
        'user_id' => 'integer',
        'extra' => 'array'
    ];

    public function getConnectionName(): ?string
    {
        return Tracker::getConnection();
    }

    public function user(): BelongsTo
    {
        $model = config('escolalms_tracker.user.model') ?? User::class;
        return $this->setConnection((new $model())->getConnectionName())->belongsTo($model, 'user_id', 'id');
    }

    protected static function newFactory(): TrackRouteFactory
    {
        return TrackRouteFactory::new();
    }
}
