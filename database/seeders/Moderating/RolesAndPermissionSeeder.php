<?php

namespace Database\Seeders\Moderating;

use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Symfony\Component\Console\Output\ConsoleOutput;

class RolesAndPermissionSeeder extends Seeder
{
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $me = Staff::create([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password')
        ]);


        $moderator = Role::create(['name' => 'moderator', 'guard_name' => 'staff']);

        $user = new Staff();
        $user->password = Hash::make('password');
        $user->email = 'moderator@mail.com';
        $user->name = 'Moderator';
        $user->save();

        $user->assignRole($moderator);

        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'staff']);
        $me->assignRole($adminRole);

        Permission::create(['name' => 'create navigations', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit navigations', 'guard_name' => 'staff']);
        Permission::create(['name' => 'delete navigations', 'guard_name' => 'staff']);

        Permission::create(['name' => 'edit contacts', 'guard_name' => 'staff']);
        Permission::create(['name' => 'view orders', 'guard_name' => 'staff']);

        Permission::create(['name' => 'create menu items', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit menu items', 'guard_name' => 'staff']);
        Permission::create(['name' => 'delete menu items', 'guard_name' => 'staff']);

        Permission::create(['name' => 'create static pages', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit static pages', 'guard_name' => 'staff']);
        Permission::create(['name' => 'delete static pages', 'guard_name' => 'staff']);

        Permission::create(['name' => 'create roles', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit roles', 'guard_name' => 'staff']);
        Permission::create(['name' => 'delete roles', 'guard_name' => 'staff']);

        Permission::create(['name' => 'create categories', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit categories', 'guard_name' => 'staff']);
        Permission::create(['name' => 'delete categories', 'guard_name' => 'staff']);

        Permission::create(['name' => 'view logs', 'guard_name' => 'staff']);
        Permission::create(['name' => 'view settings', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit user translations', 'guard_name' => 'staff']);
        Permission::create(['name' => 'generate sitemap', 'guard_name' => 'staff']);

        Permission::create(['name' => 'assign roles', 'guard_name' => 'staff']);
        Permission::create(['name' => 'assign permissions', 'guard_name' => 'staff']);

        $moderator = Role::find(1);

        $moderator->givePermissionTo('create categories');
        $moderator->givePermissionTo('edit categories');
        $moderator->givePermissionTo('delete categories');

        $output = new ConsoleOutput();
        $output->writeln("<fg=cyan>Roles and Permissions created</>");
    }
}
