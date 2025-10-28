<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'group_name' => 'dashboard',
                'permissions' => [
                    'dashboard.view',
                ],
            ],
            [
                'group_name' => 'user',
                'permissions' => [
                    'user.create',
                    'user.view',
                    'user.edit',
                    'user.delete',
                ],
            ],
            [
                'group_name' => 'task',
                'permissions' => [
                    'task.create',
                    'task.view',
                    'task.edit',
                    'task.delete',
                ],
            ],
        ];

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $customerRole = Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);
        $taskerRole = Role::firstOrCreate(['name' => 'tasker', 'guard_name' => 'web']);

        foreach ($permissions as $group) {
            foreach ($group['permissions'] as $permissionName) {
                $permission = Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                ]);

                $adminRole->givePermissionTo($permission);

                if (in_array($permissionName, ['dashboard.view', 'task.view'])) {
                    $customerRole->givePermissionTo($permission);
                }

                if (in_array($permissionName, ['dashboard.view', 'task.view', 'task.edit'])) {
                    $taskerRole->givePermissionTo($permission);
                }
            }
        }

        $users = User::all();
    
        $users->first()->assignRole('admin');

        $remainingUsers = $users->slice(1)->shuffle();
        $half = floor($remainingUsers->count() / 2);

        foreach ($remainingUsers as $index => $user) {
            $user->roles()->detach();

            if ($index < $half) {
                $user->assignRole('tasker');
            } else {
                $user->assignRole('customer');
            }
        }
    }
}
