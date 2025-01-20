<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\Permission\AccountEnum;
use App\Enums\Permission\CategoryEnum;
use App\Enums\Permission\OrderEnum;
use App\Enums\Permission\ProductEnum;
use App\Enums\Permission\UserEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class PermisssionsAndRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            ...AccountEnum::values(),
            ...CategoryEnum::values(),
            ...OrderEnum::values(),
            ...ProductEnum::values(),
            ...UserEnum::values(),
        ];

        ds($permissions);
        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        if (!Role::where('name', RoleEnum::CUSTOMER->value)->exists()) {
            Role::create(['name' => RoleEnum::CUSTOMER->value])
                ->givePermissionTo(AccountEnum::values());
        }

        if (! Role::where('name', RoleEnum::MODERATOR->value)->exists()) {
            Role::create(['name' => RoleEnum::MODERATOR->value])
                ->givePermissionTo([
                    ...CategoryEnum::values(),
                    ...ProductEnum::values(),
                ]);
        }

        if (! Role::where('name', RoleEnum::ADMIN->value)->exists()) {
            Role::create(['name' => RoleEnum::ADMIN->value])
                ->givePermissionTo(Permission::all());
        }
    }
}
