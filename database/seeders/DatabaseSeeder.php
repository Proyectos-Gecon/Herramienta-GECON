<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $e = User::where(['username' => 'ecantillo', ])->first();
        $role = Role::create(['guard_name' => 'web', 'name' => 'ADMIN']);
        $permisos = [];
        $permisos[0] = Permission::create(['guard_name' => 'web', 'name' => 'create division']);
        $permisos[1] = Permission::create(['guard_name' => 'web', 'name' => 'read division']);
        $permisos[2] = Permission::create(['guard_name' => 'web', 'name' => 'edit division']);
        $permisos[3] = Permission::create(['guard_name' => 'web', 'name' => 'delete division']);
        $role->syncPermissions($permisos);
        $e->assignRole($role);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
