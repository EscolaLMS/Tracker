<?php

namespace EscolaLms\Tracker\Migrations;

use Illuminate\Database\Migrations\Migration as BaseMigration;

class Migration extends BaseMigration
{
    public function __construct()
    {
        $this->setConnection(config('escolalms_tracker.database.connection'));
    }

    public function setConnection($connection): Migration
    {
        $this->connection = $connection;

        return $this;
    }
}
