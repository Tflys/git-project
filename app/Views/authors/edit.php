<?php
require_once 'controllers/AuthController.php';
require_once 'controllers/AuthorController.php';

$auth = new AuthController();
$auth->redirectIfNotAuthenticated();

$rol = $_SESSION['rol'] ?? '';
if ($rol !== 'admin') {
    header('Location: /index.php');
    exit();
}

$authorController = new AuthorController();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /views/authors/list.php?error=Invalid ID');
    exit();
}

$id = (int)$_GET['id'];
$author = $authorController->getAuthorById($id);

if (!$author) {
    header('Location: /views/authors/list.php?error=Author not found');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $apellidos = htmlspecialchars(trim($_POST['apellidos']));
    $nacionalidad = htmlspecialchars(trim($_POST['nacionalidad']));

    if ($authorController->updateAuthor($id, $nombre, $apellidos, $nacionalidad)) {
        header('Location: /views/authors/list.php?success=Author updated successfully');
        exit();
    } else {
        $error = "Error al actualizar el autor. Intenta de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Autor</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <h1>Editar Autor</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="/views/authors/edit.php?id=<?php echo $id; ?>" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($author['nombre']); ?>" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($author['apellidos']); ?>" required>

        <label for="nacionalidad">Nacionalidad:</label>
        <input type="text" id="nacionalidad" name="nacionalidad" value="<?php echo htmlspecialchars($author['nacionalidad']); ?>" required>

        <button type="submit" class="btn">Actualizar Autor</button>
    </form>
</body>
</html>
