<?php
require_once 'controllers/AuthController.php';
require_once 'controllers/AuthorController.php';

$auth = new AuthController();
$auth->redirectIfNotAuthenticated();

$rol = $_SESSION['rol'] ?? '';
$isAdmin = $rol === 'admin';
$isBibliotecario = $rol === 'bibliotecario';

$authorController = new AuthorController();
$authors = $authorController->listAuthors();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Autores</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <h1>Gestión de Autores</h1>

    <?php if ($isAdmin || $isBibliotecario): ?>
        <a href="/views/authors/add.php" class="btn">Agregar Autor</a>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <?php if ($isAdmin): ?>
                    <th>Acciones</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($authors as $author): ?>
                <tr>
                    <td><?php echo htmlspecialchars($author['id']); ?></td>
                    <td><?php echo htmlspecialchars($author['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($author['apellidos']); ?></td>
                    <?php if ($isAdmin): ?>
                        <td>
                            <a href="/views/authors/edit.php?id=<?php echo $author['id']; ?>" class="btn">Editar</a>
                            <a href="/views/authors/delete.php?id=<?php echo $author['id']; ?>" class="btn" onclick="return confirm('¿Seguro que quieres eliminar este autor?');">Eliminar</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
