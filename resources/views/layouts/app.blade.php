<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>AlmaTrack</title>
</head>
<body>

    <h1>ALMATRACK</h1>

    <hr>

    @auth

        <p>
            Usuario:
            {{ auth()->user()->name }}
        </p>

        <p>
            Rol:
            {{ auth()->user()->roles->first()->name ?? 'Sin rol' }}
        </p>

    @endauth

    <hr>

    @yield('content')

</body>
</html>