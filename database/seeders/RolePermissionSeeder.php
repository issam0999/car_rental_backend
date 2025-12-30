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
            'admin',
            'contact.view',
            'contact.write',
            'contact.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'api',
            ]);
        }

        // Roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'title' => 'Super Admin', 'guard_name' => 'api', 'center_id' => 1]);
        $admin = Role::firstOrCreate(['name' => 'admin', 'title' => 'Admin', 'guard_name' => 'api', 'center_id' => 1]);
        $crm = Role::firstOrCreate(['name' => 'crm', 'title' => 'CRM', 'guard_name' => 'api', 'center_id' => 1]);

        // Assign permissions to roles
        $admin->syncPermissions(['admin']);
        $crm->syncPermissions(['contact.view', 'contact.write', 'contact.delete']);

        // Assign roles
        $user = User::find(1);
        $user->assignRole($superAdmin);
    }
}
