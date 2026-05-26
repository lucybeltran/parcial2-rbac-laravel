<?php

namespace App\Policies;

use App\Models\User;

class MovementPolicy
{
    /**
     * Determina si el usuario puede registrar un movimiento (Punto 8)
     */
    public function create(User $user, int $warehouseId): bool
    {
        // 1. Verificar si el usuario tiene el permiso base en su rol
        if ($user->hasPermissionTo('registrar movimiento')) {
            
            // 2. Si tiene el rol de almacenista, obligatoriamente debe coincidir el almacén
            if ($user->hasRole('almacenista')) {
                return (int) $user->warehouse_id === (int) $warehouseId;
            }

            // 3. Si es admin o supervisor con el permiso, pueden registrar en cualquier almacén
            return true;
        }

        return false;
    }

    /**
     * Determina si el usuario puede aprobar un movimiento (Punto 8)
     */
    public function approve(User $user): bool
    {
        // Pasa estrictamente si el usuario posee el permiso explícito
        return $user->hasPermissionTo('aprobar movimiento');
    }
}