<?php
require_once 'controllers/AuthController.php';
require_once 'controllers/AuthorController.php';

$auth = new AuthController();
$auth->redirectIfNotAuthenticated();

$rol = $_SESSION['rol'] ?? '';
if ($rol !== 'admin' && $rol !== 'bibliotecario') {
    header('Location: /index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $apellidos = htmlspecialchars(trim($_POST['apellidos']));
    $authorController = new AuthorController();

    if ($authorController->insertAuthor($nombre, $apellidos)) {
        header('Location: /views/authors/list.php?success=1');
        exit();
    } else {
        $error = "Error al agregar el autor. Intenta de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Autor</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <h1>Agregar Autor</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="/views/authors/add.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required>

        <button type="submit" class="btn">Agregar Autor</button>
    </form>
</body>
</html>
