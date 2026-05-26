<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Spatie\Permission\PermissionRegistrar;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    /**
     * Middleware Laravel 13
     */
    public static function middleware(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | SOLO ADMIN PUEDE GESTIONAR ROLES
            |--------------------------------------------------------------------------
            */

            new Middleware(
                'permission:gestionar roles',
                only: [
                    'index',
                    'create',
                    'store',
                    'edit',
                    'update',
                    'destroy'
                ]
            ),
        ];
    }

    /**
     * Listar roles
     */
    public function index()
    {
        $roles = Role::where('guard_name', 'web')->get();

        return view('roles.index', compact('roles'));
    }

    /**
     * Formulario crear
     */
    public function create()
    {
        $permissions = Permission::where(
            'guard_name',
            'web'
        )->get();

        return view(
            'roles.create',
            compact('permissions')
        );
    }

    /**
     * Guardar rol
     */
    public function store(Request $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        $role->syncPermissions(
            $request->permissions ?? []
        );

        /*
        |--------------------------------------------------------------------------
        | LIMPIAR CACHE
        |--------------------------------------------------------------------------
        */

        app()[PermissionRegistrar::class]
            ->forgetCachedPermissions();

        return redirect()->route('roles.index');
    }

    /**
     * Editar rol
     */
    public function edit(Role $role)
    {
        $permissions = Permission::where(
            'guard_name',
            'web'
        )->get();

        return view(
            'roles.edit',
            compact('role', 'permissions')
        );
    }

    /**
     * Actualizar rol
     */
    public function update(
        Request $request,
        Role $role
    ) {
        $role->update([
            'name' => $request->name
        ]);

        $role->syncPermissions(
            $request->permissions ?? []
        );

        /*
        |--------------------------------------------------------------------------
        | LIMPIAR CACHE
        |--------------------------------------------------------------------------
        */

        app()[PermissionRegistrar::class]
            ->forgetCachedPermissions();

        return redirect()->route('roles.index');
    }

    /**
     * Eliminar rol
     */
    public function destroy(Role $role)
    {
        /*
        |--------------------------------------------------------------------------
        | NO ELIMINAR ADMIN
        |--------------------------------------------------------------------------
        */

        if ($role->name === 'admin') {

            return back()->with(
                'error',
                'No se puede eliminar el rol admin'
            );
        }

        $role->delete();

        /*
        |--------------------------------------------------------------------------
        | LIMPIAR CACHE
        |--------------------------------------------------------------------------
        */

        app()[PermissionRegistrar::class]
            ->forgetCachedPermissions();

        return redirect()->route('roles.index');
    }
}