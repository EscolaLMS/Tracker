<?php

use EscolaLms\Tracker\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackRoutesTableConfigurableConnection extends Migration
{
    public function up()
    {
        if (!Schema::connection($this->connection)->hasTable('track_routes')) {
            Schema::connection($this->connection)->create('track_routes', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->text('path')->nullable();
                $table->text('full_path')->nullable();
                $table->text('method')->nullable();
                $table->json('extra')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::connection($this->connection)->dropIfExists('track_routes');
    }
}
