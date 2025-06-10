<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'restore users']);

        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'view marketing case studies']);
        Permission::create(['name' => 'create marketing case studies']);
        Permission::create(['name' => 'edit marketing case studies']);
        Permission::create(['name' => 'upload marketing case studies files']);
        Permission::create(['name' => 'download marketing case studies files']);
        Permission::create(['name' => 'delete marketing case studies files']);
        Permission::create(['name' => 'delete marketing case studies']);

        // update cache to know about the newly created permissions (required if using WithoutModelEvents in seeders)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create roles and assign created permissions
        Role::create(['name' => 'SUPER-ADMIN'])
            ->givePermissionTo(Permission::all());

        Role::create(['name' => 'MARKETING'])
            ->givePermissionTo([
                'view marketing case studies',
                'create marketing case studies',
                'edit marketing case studies',
                'upload marketing case studies files',
                'download marketing case studies files',
                'delete marketing case studies files',
                'delete marketing case studies',
            ]);

    }
}
