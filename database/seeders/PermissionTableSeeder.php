<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role_permission-list',
            'role_permission-create',
            'role_permission-edit',
            'role_permission-delete',

            'user_management-list',
            'user_management-create',
            'user_management-edit',
            'user_management-delete',

            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
