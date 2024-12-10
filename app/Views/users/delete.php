<?php
use App\Models\User;

if (isset($user)) {
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario</title>
    <link rel="stylesheet" href="/public/styles.css">
</head>
<body>
    <h1>Eliminar Usuario</h1>

    <p>¿Estás seguro de que quieres eliminar al usuario "<?php echo htmlspecialchars($user['login']); ?>"?</p>

    <form action="/users/destroy.php" method="post">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <button type="submit">Sí, eliminar</button>
    </form>

    <a href="/users/list.php">Cancelar</a>

</body>
</html>

<?php
} else {
    echo "Usuario no encontrado.";
}
?>
