<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'Create users', 'key' => 'users.create'],
            ['name' => 'View users', 'key' => 'users.view'],
            ['name' => 'Update users', 'key' => 'users.update'],
            ['name' => 'Change user status', 'key' => 'users.status'],
            ['name' => 'Create patients', 'key' => 'patients.create'],
            ['name' => 'View patients', 'key' => 'patients.view'],
            ['name' => 'Update patients', 'key' => 'patients.update'],
            ['name' => 'Manage departments', 'key' => 'departments.manage'],
            ['name' => 'Manage doctors', 'key' => 'doctors.manage'],
            ['name' => 'View doctors', 'key' => 'doctors.view'],
            ['name' => 'Create appointments', 'key' => 'appointments.create'],
            ['name' => 'View appointments', 'key' => 'appointments.view'],
            ['name' => 'Update appointments', 'key' => 'appointments.update'],
        ];

        foreach ($permissions as $permission) {
            Permission::query()->updateOrCreate(['key' => $permission['key']], $permission);
        }
    }
}
