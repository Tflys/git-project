<?php
use App\Models\User;

if (isset($user)) {
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="/public/styles.css">
</head>
<body>
    <h1>Editar Usuario</h1>

    <form action="/users/update.php" method="post">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

        <label for="login">Nombre de Usuario</label>
        <input type="text" name="login" id="login" value="<?php echo htmlspecialchars($user['login']); ?>" required>

        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password">

        <label for="rol">Rol</label>
        <select name="rol" id="rol" required>
            <option value="admin" <?php echo $user['rol'] === 'admin' ? 'selected' : ''; ?>>Administrador</option>
            <option value="user" <?php echo $user['rol'] === 'user' ? 'selected' : ''; ?>>Usuario</option>
            <option value="bibliotecario" <?php echo $user['rol'] === 'bibliotecario' ? 'selected' : ''; ?>>Bibliotecario</option>
        </select>

        <button type="submit">Actualizar Usuario</button>
    </form>

</body>
</html>

<?php
} else {
    echo "Usuario no encontrado.";
}
?>
