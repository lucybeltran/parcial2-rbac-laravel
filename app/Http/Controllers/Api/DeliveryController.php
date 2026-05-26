<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Delivery;

class DeliveryController extends Controller
{
    /**
     * Confirmar entrega
     */
    public function confirm($id)
    {
        $delivery = Delivery::findOrFail($id);

        $delivery->status = 'confirmada';

        $delivery->save();

        return response()->json([
            'message' => 'Entrega confirmada correctamente',
            'delivery' => $delivery
        ]);
    }
}