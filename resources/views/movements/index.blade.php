<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Movimientos - AlmaTrack</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: #1e293b;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            margin: 0;
        }

        .navbar .user {
            font-size: 14px;
        }

        .container {
            width: 90%;
            margin: 30px auto;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .btn {
            display: inline-block;
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #4b5563;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th {
            background: #1e293b;
            color: white;
            padding: 12px;
            text-align: left;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-success { background: #d1fae5; color: #065f46; }

        .text-entrada { color: #16a34a; font-weight: bold; }
        .text-salida { color: #dc2626; font-weight: bold; }
    </style>
</head>
<body>

    <div class="navbar">
        <h2>AlmaTrack - Gestión de Flujos</h2>
        <div class="user">
            Usuario: <strong>{{ auth()->user()->name }}</strong>
        </div>
    </div>

    <div class="container">

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1>Historial y Aprobación de Movimientos</h1>
                <a href="/products" class="btn btn-secondary">Regresar a Productos</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Almacén</th>
                        <th>Producto ID</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Estado</th>
                        <th>Acción Operativa</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movements as $movement)
                    <tr>
                        <td>{{ $movement->id }}</td>
                        <td>Almacén #{{ $movement->warehouse_id }}</td>
                        <td>Producto #{{ $movement->product_id }}</td>
                        <td>
                            <span class="{{ $movement->type === 'entrada' ? 'text-entrada' : 'text-salida' }}">
                                {{ strtoupper($movement->type) }}
                            </span>
                        </td>
                        <td>{{ $movement->quantity }} uds.</td>
                        <td>
                            @if($movement->status === 'pendiente')
                                <span class="badge badge-warning">PENDIENTE</span>
                            @else
                                <span class="badge badge-success">APROBADO</span>
                            @endif
                        </td>
                        <td>
                            @if($movement->status === 'pendiente')
                                @can('approve', $movement)
                                    <form method="POST" action="/movements/{{ $movement->id }}/approve">
                                        @csrf
                                        <button type="submit" class="btn btn-primary" style="padding: 5px 10px; font-size: 13px;">
                                            Aprobar Cambios
                                        </button>
                                    </form>
                                @else
                                    <span style="color:#94a3b8; font-size:13px;">Sin autorización</span>
                                @endcan
                            @else
                                <span style="color:#16a34a; font-size:13px; font-weight:bold;">✓ Procesado</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #64748b; padding: 20px;">
                            No hay movimientos de inventario registrados en el sistema.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>