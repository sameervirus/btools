<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'admin', 'name_ar' => 'مدير']);
        $permission = Permission::create(['name' => 'manage users', 'name_ar' => 'ادارة المستخدمين']);$role->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'manage roles', 'name_ar' => 'إدارة الوظائف']);$role->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'coding', 'name_ar' => 'التكويد']);$role->givePermissionTo($permission);
    }
}
