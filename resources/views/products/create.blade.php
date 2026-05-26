<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto</title>
</head>
<body>

    <h1>CREAR PRODUCTO</h1>

    <form action="/products" method="POST">

        @csrf

        <label>
            Nombre
        </label>

        <br>

        <input
            type="text"
            name="name"
        >

        <br><br>

        <label>
            Precio
        </label>

        <br>

        <input
            type="number"
            name="price"
        >

        <br><br>

        <label>
            Stock
        </label>

        <br>

        <input
            type="number"
            name="stock"
        >

        <br><br>

        <button type="submit">
            Guardar
        </button>

    </form>

</body>
</html>