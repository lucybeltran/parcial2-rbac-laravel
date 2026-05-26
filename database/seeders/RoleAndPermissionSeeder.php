<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | LIMPIAR CACHE
        |--------------------------------------------------------------------------
        */

        app()[PermissionRegistrar::class]
            ->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | PERMISOS WEB
        |--------------------------------------------------------------------------
        */

        Permission::create([
            'name' => 'ver productos',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'crear productos',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'editar productos',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'eliminar productos',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'registrar movimiento',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'aprobar movimiento',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'gestionar roles',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | PERMISOS API
        |--------------------------------------------------------------------------
        */

        Permission::create([
            'name' => 'ver productos',
            'guard_name' => 'api',
        ]);

        Permission::create([
            'name' => 'confirmar entrega',
            'guard_name' => 'api',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ROLES WEB
        |--------------------------------------------------------------------------
        */

        $admin = Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $supervisor = Role::create([
            'name' => 'supervisor',
            'guard_name' => 'web',
        ]);

        $almacenista = Role::create([
            'name' => 'almacenista',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ROL API
        |--------------------------------------------------------------------------
        */

        $repartidor = Role::create([
            'name' => 'repartidor',
            'guard_name' => 'api',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ASIGNAR PERMISOS ADMIN
        |--------------------------------------------------------------------------
        */

        $admin->givePermissionTo([
            Permission::where('name', 'ver productos')
                ->where('guard_name', 'web')
                ->first(),

            Permission::where('name', 'crear productos')
                ->where('guard_name', 'web')
                ->first(),

            Permission::where('name', 'editar productos')
                ->where('guard_name', 'web')
                ->first(),

            Permission::where('name', 'eliminar productos')
                ->where('guard_name', 'web')
                ->first(),

            Permission::where('name', 'registrar movimiento')
                ->where('guard_name', 'web')
                ->first(),

            Permission::where('name', 'aprobar movimiento')
                ->where('guard_name', 'web')
                ->first(),

            Permission::where('name', 'gestionar roles')
                ->where('guard_name', 'web')
                ->first(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | ASIGNAR PERMISOS SUPERVISOR
        |--------------------------------------------------------------------------
        */

        $supervisor->givePermissionTo([
            Permission::where('name', 'ver productos')
                ->where('guard_name', 'web')
                ->first(),

            Permission::where('name', 'editar productos')
                ->where('guard_name', 'web')
                ->first(),

            Permission::where('name', 'registrar movimiento')
                ->where('guard_name', 'web')
                ->first(),

            Permission::where('name', 'aprobar movimiento')
                ->where('guard_name', 'web')
                ->first(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | ASIGNAR PERMISOS ALMACENISTA
        |--------------------------------------------------------------------------
        */

        $almacenista->givePermissionTo([
            Permission::where('name', 'ver productos')
                ->where('guard_name', 'web')
                ->first(),

            Permission::where('name', 'registrar movimiento')
                ->where('guard_name', 'web')
                ->first(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | ASIGNAR PERMISOS REPARTIDOR API
        |--------------------------------------------------------------------------
        */

        $repartidor->givePermissionTo([
            Permission::where('name', 'ver productos')
                ->where('guard_name', 'api')
                ->first(),

            Permission::where('name', 'confirmar entrega')
                ->where('guard_name', 'api')
                ->first(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | USUARIO ADMIN
        |--------------------------------------------------------------------------
        */

        $userAdmin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@almatrack.com',
            'password' => Hash::make('12345678'),
            'warehouse_id' => 1,
        ]);

        $userAdmin->assignRole('admin');

        /*
        |--------------------------------------------------------------------------
        | USUARIO SUPERVISOR
        |--------------------------------------------------------------------------
        */

        $userSupervisor = User::create([
            'name' => 'Supervisor',
            'email' => 'supervisor@almatrack.com',
            'password' => Hash::make('12345678'),
            'warehouse_id' => 1,
        ]);

        $userSupervisor->assignRole('supervisor');

        /*
        |--------------------------------------------------------------------------
        | USUARIO ALMACENISTA
        |--------------------------------------------------------------------------
        */

        $userAlmacenista = User::create([
            'name' => 'Almacenista',
            'email' => 'almacenista@almatrack.com',
            'password' => Hash::make('12345678'),
            'warehouse_id' => 2,
        ]);

        $userAlmacenista->assignRole('almacenista');

        /*
        |--------------------------------------------------------------------------
        | USUARIO REPARTIDOR API
        |--------------------------------------------------------------------------
        |
        | Este usuario usará Sanctum para autenticarse en la API.
        | No se asigna rol web porque pertenece al guard api.
        |
        */

        User::create([
            'name' => 'Repartidor',
            'email' => 'repartidor@almatrack.com',
            'password' => Hash::make('12345678'),
            'warehouse_id' => 3,
        ]);
    }
}