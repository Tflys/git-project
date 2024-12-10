<?php
session_start();

// Redirigir si el usuario no está autenticado
if (!isset($_SESSION['user'])) {
    header('Location: /auth/login.php');
    exit;
}

// Redirigir a la página de inicio según el rol
if ($_SESSION['rol'] === 'admin') {
    header('Location: /admin/dashboard.php');
} elseif ($_SESSION['rol'] === 'user') {
    header('Location: /user/dashboard.php');
} elseif ($_SESSION['rol'] === 'bibliotecario') {
    header('Location: /bibliotecario/dashboard.php');
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a la Biblioteca</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Bienvenido a la Biblioteca</h1>
        <nav>
            <a href="/books/list.php">Libros</a>
            <a href="/users/list.php">Usuarios</a>
            <a href="/auth/logout.php">Cerrar sesión</a>
        </nav>
    </header>

    <main>
        <h2>Panel de control</h2>
        <p>Elige una de las opciones del menú para gestionar la biblioteca.</p>
    </main>

    <footer>
        <p>&copy; 2024 Biblioteca - Todos los derechos reservados.</p>
    </footer>
</body>
</html>
