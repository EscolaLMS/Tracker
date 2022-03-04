<?php

namespace EscolaLms\Tracker\Migrations;

use EscolaLms\Tracker\Facades\Tracker;
use Illuminate\Database\Migrations\Migration as BaseMigration;

class Migration extends BaseMigration
{
    public function __construct()
    {
        $this->setConnection(Tracker::getConnection());
    }

    public function setConnection($connection): Migration
    {
        $this->connection = $connection;

        return $this;
    }
}
