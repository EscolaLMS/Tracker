<?php

namespace EscolaLms\Tracker\Database\Seeders;

use EscolaLms\Tracker\Enums\TrackerPermissionEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TrackerPermissionSeeder extends Seeder
{
    public function run()
    {
        $admin = Role::findOrCreate('admin', 'api');

        foreach (TrackerPermissionEnum::asArray() as $const => $value) {
            Permission::findOrCreate($value, 'api');
        }

        $admin->givePermissionTo([
            TrackerPermissionEnum::TRACK_ROUTE_LIST,
        ]);
    }
}
