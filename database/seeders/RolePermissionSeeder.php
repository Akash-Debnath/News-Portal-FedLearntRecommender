<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds-
     *
     * @return void
     */
    public function run()
    {
        // Create Roles
        $roleSuperAdmin = Role::create(['name' => 'superadmin']);
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleManager = Role::create(['name'=>'manager']);
        $roleManagement = Role::create(['name'=>'management']);
        $roleUser = Role::create(['name'=>'user']);
        $roleEditor = Role::create(['name'=>'editor']);
        $rolePublisher = Role::create(['name'=>'publisher']);


        // Permission List as array
        $permissions = [
            [
                // navigation
                'group_name' => 'nav',
                'permissions' => [
                    'nav-home',
                    'nav-categories',
                    'nav-tag',
                    'nav-rolepermissions',
                ]
            ],
            [
                'group_name' => 'article',
                'permissions' => [
                    'article-create',
                    'article-view',
                    'article-edit',
                    'article-delete',
                    'article-approve',
                ]
            ],
            [
                'group_name' => 'categories',
                'permissions' => [
                    'categories-create',
                    'categories-view',
                    'categories-edit',
                    'categories-delete',
                    'categories-approve',
                ]
            ],
            [
                'group_name' => 'tag',
                'permissions' => [
                    'tag-create',
                    'tag-view',
                    'tag-edit',
                    'tag-delete',
                    'tag-approve',
                ]
            ],
            [
                'group_name' => 'roleAndPermissionSet',
                'permissions' => [
                    // note roleAndPermission
                    'roleAndPermission-create',
                    'roleAndPermission-view',
                    'roleAndPermission-edit',
                    'roleAndPermission-delete',
                    'roleAndPermission-refuse',
                    'roleAndPermission-approve',
                ]
            ],
        ];


        // Create and Assign Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create Permission
                $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup]);
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
            }
        }
    }
}
