<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Product; // <-- Importante importar el modelo Product
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB; // <-- Importante para asegurar la atomicidad

class MovementController extends Controller
{
    /**
     * Muestra el panel general de movimientos
     */
    public function index()
    {
        $movements = Movement::orderBy('created_at', 'desc')->get();
        return view('movements.index', compact('movements'));
    }

    /**
     * Proceso de guardado seguro de un movimiento (Punto 8 y 9)
     */
    public function store(Request $request)
    {
        // 1. Validar rigurosamente los datos del formulario entrante
        $validated = $request->validate([
            'warehouse_id' => 'required|integer',
            'product_id'   => 'required|integer',
            'type'         => 'required|in:entrada,salida',
            'quantity'     => 'required|integer|min:1',
        ]);

        // 2. Ejecutar la Policy nativa pasando la clase y el ID del almacén destino
        Gate::authorize('create', [Movement::class, (int) $validated['warehouse_id']]);

        // [Nota de Seguridad]: Aquí NO alteramos el stock aún, porque nace "pendiente" 
        // según el flujo requerido por la empresa AlmaTrack S.R.L.
        Movement::create([
            'warehouse_id' => (int) $validated['warehouse_id'],
            'product_id'   => (int) $validated['product_id'],
            'user_id'      => Auth::id(), 
            'type'         => $validated['type'],
            'quantity'     => (int) $validated['quantity'],
            'status'       => 'pendiente', // Por defecto nace pendiente
        ]);

        // 4. Redireccionar explícitamente a la lista de productos con un mensaje de éxito
        return redirect('/products')->with('success', 'Movimiento registrado correctamente en espera de aprobación.');
    }

    /**
     * Proceso de aprobación de un movimiento (Punto 8 y 9)
     * ¡Aquí es donde el stock sube o baja realmente!
     */
    public function approve(Movement $movement)
    {
        // 1. Ejecutar la Policy para verificar el permiso 'aprobar movimiento'
        Gate::authorize('approve', $movement);

        // 2. Buscar el producto asociado al movimiento
        $product = Product::findOrFail($movement->product_id);

        // 3. Control de Seguridad: Evitar que el stock caiga a números negativos si es una salida
        if ($movement->type === 'salida' && $product->stock < $movement->quantity) {
            return redirect('/movements')->withErrors([
                'error' => 'No se puede aprobar: El stock actual es insuficiente para procesar esta salida.'
            ]);
        }

        // 4. Asegurar con una transacción que se apruebe el movimiento Y se altere el stock al mismo tiempo
        DB::transaction(function () use ($movement, $product) {
            
            // A. Cambiar el estado a aprobado
            $movement->update([
                'status' => 'aprobado',
            ]);

            // B. Alterar el stock del producto según corresponda
            if ($movement->type === 'entrada') {
                $product->increment('stock', $movement->quantity); // Sube stock
            } else {
                $product->decrement('stock', $movement->quantity); // Baja stock
            }
        });

        return redirect('/movements')->with('success', 'El movimiento ha sido aprobado y el stock del inventario se actualizó con éxito.');
    }
}