<?php
use App\Models\User;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Usuarios</title>
    <link rel="stylesheet" href="/public/styles.css">
</head>
<body>
    <h1>Listado de Usuarios</h1>

    <a href="/users/create.php">Agregar nuevo usuario</a>

    <table>
        <thead>
            <tr>
                <th>Nombre de Usuario</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['login']); ?></td>
                <td><?php echo htmlspecialchars($user['rol']); ?></td>
                <td>
                    <a href="/users/edit.php?id=<?php echo $user['id']; ?>">Editar</a> | 
                    <a href="/users/delete.php?id=<?php echo $user['id']; ?>">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
