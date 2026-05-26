<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Autentica al usuario de la API (Repartidor) y retorna su Token Sanctum
     */
    public function login(Request $request)
    {
        // 1. Validar las credenciales entrantes de Bruno
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // 2. Buscar al usuario en la base de datos
        $user = User::where('email', $request->email)->first();

        // 3. Verificar existencia y contraseña encriptada
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Las credenciales proporcionadas son incorrectas.'
            ], 401);
        }

        // 4. Crear el token asignándole la habilidad/guard de API
        $token = $user->createToken('TokenRepartidor', ['api'])->plainTextToken;

        // 5. Retornar respuesta exitosa estructurada en JSON
        return response()->json([
            'status'  => 'success',
            'message' => 'Autenticación exitosa',
            'token'   => $token,
            'user'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->roles->pluck('name')->first() ?? 'repartidor'
            ]
        ], 200);
    }
}