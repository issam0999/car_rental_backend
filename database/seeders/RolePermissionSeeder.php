<?php

namespace Database\Seeders;

use App\Models\User;
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
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Contact permissions
        $permissions = [
            ['name' => 'admin', 'module' => 'admin'],
            ['name' => 'contacts.view', 'module' => 'contacts'],
            ['name' => 'contacts.create', 'module' => 'contacts'],
            ['name' => 'contacts.update', 'module' => 'contacts'],
            ['name' => 'contacts.delete', 'module' => 'contacts'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission['name'],
                'module' => $permission['module'],
                'guard_name' => 'api',
            ]);
        }

        // Roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'api', 'center_id' => 1]);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api', 'center_id' => 1]);
        $crm = Role::firstOrCreate(['name' => 'crm', 'guard_name' => 'api', 'center_id' => 1]);

        // Assign permissions to roles
        $admin->syncPermissions(['admin']);
        $crm->syncPermissions(['contacts.view', 'contacts.create', 'contacts.update', 'contacts.delete']);

        // Assign roles
        $user = User::find(1);
        $user->assignRole($superAdmin);
        $user->assignRole($crm);
    }
}
