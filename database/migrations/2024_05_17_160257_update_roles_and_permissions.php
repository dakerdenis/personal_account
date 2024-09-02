<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration {
    public function up(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::query()->whereIn('name', ['view orders', 'delete roles', 'view logs', 'create roles', 'edit roles', 'assign roles', 'assign permissions'])->delete();

        Permission::create(['name' => 'create products', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit products', 'guard_name' => 'staff']);
        Permission::create(['name' => 'delete products', 'guard_name' => 'staff']);

        Permission::create(['name' => 'create managers', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit managers', 'guard_name' => 'staff']);
        Permission::create(['name' => 'delete managers', 'guard_name' => 'staff']);

        Permission::create(['name' => 'create branches', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit branches', 'guard_name' => 'staff']);
        Permission::create(['name' => 'delete branches', 'guard_name' => 'staff']);

        Permission::create(['name' => 'create departments', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit departments', 'guard_name' => 'staff']);
        Permission::create(['name' => 'delete departments', 'guard_name' => 'staff']);

        Permission::create(['name' => 'create reports data', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit reports data', 'guard_name' => 'staff']);
        Permission::create(['name' => 'delete reports data', 'guard_name' => 'staff']);

        Permission::create(['name' => 'create files', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit files', 'guard_name' => 'staff']);
        Permission::create(['name' => 'delete files', 'guard_name' => 'staff']);

        Permission::create(['name' => 'create partners', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit partners', 'guard_name' => 'staff']);
        Permission::create(['name' => 'delete partners', 'guard_name' => 'staff']);

        Permission::create(['name' => 'create articles', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit articles', 'guard_name' => 'staff']);
        Permission::create(['name' => 'delete articles', 'guard_name' => 'staff']);

        Permission::create(['name' => 'create vacancies', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit vacancies', 'guard_name' => 'staff']);
        Permission::create(['name' => 'delete vacancies', 'guard_name' => 'staff']);

        Permission::create(['name' => 'create faqs', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit faqs', 'guard_name' => 'staff']);
        Permission::create(['name' => 'delete faqs', 'guard_name' => 'staff']);

        Permission::create(['name' => 'create blocks', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit blocks', 'guard_name' => 'staff']);
        Permission::create(['name' => 'delete blocks', 'guard_name' => 'staff']);


        Permission::create(['name' => 'create useful_links', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit useful_links', 'guard_name' => 'staff']);
        Permission::create(['name' => 'delete useful_links', 'guard_name' => 'staff']);

        Permission::create(['name' => 'create insurance_types', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit insurance_types', 'guard_name' => 'staff']);
        Permission::create(['name' => 'delete insurance_types', 'guard_name' => 'staff']);

        Permission::create(['name' => 'create galleries', 'guard_name' => 'staff']);
        Permission::create(['name' => 'edit galleries', 'guard_name' => 'staff']);
        Permission::create(['name' => 'delete galleries', 'guard_name' => 'staff']);

        Permission::create(['name' => 'manage sliders', 'guard_name' => 'staff']);

        Permission::create(['name' => 'access api data', 'guard_name' => 'staff']);
    }
};
