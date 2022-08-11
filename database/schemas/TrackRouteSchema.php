<?php

namespace EscolaLms\Tracker\Database\Schemas;

use Closure;
use Illuminate\Database\Schema\Blueprint;

class TrackRouteSchema
{
    public static function schema(): Closure
    {
        return function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('path')->nullable();
            $table->text('full_path')->nullable();
            $table->text('method')->nullable();
            $table->json('extra')->nullable();
            $table->timestamps();
        };
    }
}
