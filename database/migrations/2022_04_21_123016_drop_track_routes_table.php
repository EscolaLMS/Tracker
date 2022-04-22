<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTrackRoutesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('track_routes');
    }

    public function down()
    {
        Schema::create('track_routes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('path')->nullable();
            $table->text('full_path')->nullable();
            $table->text('method')->nullable();
            $table->json('extra')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }
}
