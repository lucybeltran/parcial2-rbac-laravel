<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos - AlmaTrack</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f4f6f9;
            margin:0;
            padding:0;
        }

        .navbar{
            background:#1e293b;
            color:white;
            padding:15px 30px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .navbar h2{
            margin:0;
        }

        .navbar .user{
            font-size:14px;
        }

        .container{
            width:90%;
            margin:30px auto;
        }

        .card{
            background:white;
            padding:25px;
            border-radius:10px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
        }

        .btn{
            display:inline-block;
            padding:10px 18px;
            border:none;
            border-radius:6px;
            text-decoration:none;
            cursor:pointer;
            font-size:14px;
        }

        .btn-primary{
            background:#2563eb;
            color:white;
        }

        .btn-success{
            background:#16a34a;
            color:white;
        }

        .btn-danger{
            background:#dc2626;
            color:white;
        }

        .btn-dark{
            background:#111827;
            color:white;
        }

        .btn-secondary{
            background:#4b5563;
            color:white;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        table th{
            background:#1e293b;
            color:white;
            padding:12px;
        }

        table td{
            padding:12px;
            border-bottom:1px solid #ddd;
            vertical-align: middle;
        }

        .top-buttons{
            display:flex;
            gap: 10px;
            align-items: center;
            margin-bottom:20px;
        }

        form{
            display:inline;
        }

        .form-select-sm, .form-input-sm {
            padding: 6px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h2>AlmaTrack</h2>

        <div class="user">
            Usuario:
            <strong>{{ auth()->user()->name }}</strong>

            @role('admin')
                (Administrador)
            @endrole

            @role('supervisor')
                (Supervisor)
            @endrole

            @role('almacenista')
                (Almacenista)
            @endrole
        </div>
    </div>

    <div class="container">

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-weight: bold;">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">

            <h1>Lista de Productos</h1>

            <div class="top-buttons">

                @can('crear productos')
                    <a href="/products/create" class="btn btn-primary">
                        Crear Producto
                    </a>
                @endcan

                {{-- Solo Admin y Supervisor entran a auditar y aprobar movimientos --}}
                @hasanyrole('supervisor|admin')
                    <a href="/movements" class="btn btn-secondary">
                        Ver Movimientos
                    </a>
                @endhasanyrole

                @role('admin')
                    <a href="/roles" class="btn btn-dark">
                        Gestionar Roles
                    </a>
                @endrole

                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        Cerrar Sesión
                    </button>
                </form>

            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones / Movimientos</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($products as $product)

                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->price, 2) }}</td>
                        <td><strong>{{ $product->stock }}</strong> uds.</td>

                        <td>
                            @can('editar productos')
                                <a href="/products/{{ $product->id }}/edit"
                                   class="btn btn-primary" style="padding: 6px 12px;">
                                     Editar
                                </a>
                            @endcan

                            @can('eliminar productos')
                                <form method="POST" action="/products/{{ $product->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" style="padding: 6px 12px;">
                                        Eliminar
                                    </button>
                                </form>
                            @endcan

                            {{-- Evaluamos el permiso del Rol para pintar el formulario operativo --}}
                            @can('registrar movimiento')
                                <div style="display: inline-block; margin-left: 15px; padding-left: 15px; border-left: 2px solid #e2e8f0;">
                                    <form method="POST" action="/movements">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        
                                        {{-- Si es un Admin/Supervisor sin almacén fijo, enviamos por defecto el almacén 1 para evitar nulos --}}
                                        <input type="hidden" name="warehouse_id" value="{{ auth()->user()->warehouse_id ?? 1 }}">
                                        
                                        <select name="type" class="form-select-sm" required>
                                            <option value="entrada">Entrada</option>
                                            <option value="salida">Salida</option>
                                        </select>

                                        <input type="number" name="quantity" class="form-input-sm" min="1" placeholder="Cant." style="width: 60px;" required>

                                        <button type="submit" class="btn btn-success" style="padding: 6px 12px;">
                                            Movimiento
                                        </button>
                                    </form>
                                </div>
                            @endcan

                        </td>
                    </tr>

                    @endforeach

                </tbody>
            </table>

        </div>

    </div>

</body>
</html>