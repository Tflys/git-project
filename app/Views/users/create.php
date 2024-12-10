<?php
use App\Models\User;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Usuario</title>
    <link rel="stylesheet" href="/public/styles.css">
</head>
<body>
    <h1>Agregar Nuevo Usuario</h1>

    <form action="/users/store.php" method="post">
        <label for="login">Nombre de Usuario</label>
        <input type="text" name="login" id="login" required>

        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" required>

        <label for="rol">Rol</label>
        <select name="rol" id="rol" required>
            <option value="admin">Administrador</option>
            <option value="user">Usuario</option>
            <option value="bibliotecario">Bibliotecario</option>
        </select>

        <button type="submit">Guardar Usuario</button>
    </form>

</body>
</html>
