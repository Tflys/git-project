<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $server = trim($_POST['db_server']);
    $port = trim($_POST['db_port']);
    $username = trim($_POST['db_username']);
    $password = trim($_POST['db_password']);
    $database = trim($_POST['db_database']);

    // Validar campos
    if (empty($server) || empty($port) || empty($username) || empty($database)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        // Intentar conexión y creación de base de datos
        try {
            $dsn = "mysql:host=$server;port=$port";
            $pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            // Crear la base de datos si no existe
            $pdo->exec("CREATE DATABASE IF NOT EXISTS $database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE $database");

            // Crear tablas
            $sqlUsuarios = "CREATE TABLE IF NOT EXISTS usuarios (
                id INT AUTO_INCREMENT PRIMARY KEY,
                login VARCHAR(50) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                rol ENUM('admin', 'bibliotecario', 'usuario') NOT NULL DEFAULT 'usuario',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $pdo->exec($sqlUsuarios);

            $sqlAutores = "CREATE TABLE IF NOT EXISTS autores (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(100) NOT NULL,
                apellidos VARCHAR(100) NOT NULL,
                nacionalidad VARCHAR(100),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $pdo->exec($sqlAutores);

            $sqlLibros = "CREATE TABLE IF NOT EXISTS libros (
                id INT AUTO_INCREMENT PRIMARY KEY,
                titulo VARCHAR(255) NOT NULL,
                autor_id INT NOT NULL,
                genero VARCHAR(100),
                numero_copias INT NOT NULL DEFAULT 1,
                numero_paginas INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (autor_id) REFERENCES autores(id) ON DELETE CASCADE
            )";
            $pdo->exec($sqlLibros);

            // Crear usuario administrador inicial
            $adminPassword = password_hash('admin123', PASSWORD_BCRYPT);
            $sqlAdmin = "INSERT IGNORE INTO usuarios (login, password, rol) VALUES 
                ('admin', '$adminPassword', 'admin')";
            $pdo->exec($sqlAdmin);

            // Guardar configuración en config.php
            $configContent = "<?php\n";
            $configContent .= "define('DB_SERVER', '$server');\n";
            $configContent .= "define('DB_PORT', '$port');\n";
            $configContent .= "define('DB_USERNAME', '$username');\n";
            $configContent .= "define('DB_PASSWORD', '$password');\n";
            $configContent .= "define('DB_DATABASE', '$database');\n";
            $configContent .= "?>";

            file_put_contents('config/config.php', $configContent);

            $success = "Instalación completada. Usuario admin creado (login: 'admin', contraseña: 'admin123').";
        } catch (PDOException $e) {
            $error = "Error al conectar o instalar: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalación - Biblioteca</title>
</head>
<body>
    <h1>Instalación del Sistema Biblioteca</h1>
    <?php if (!empty($success)): ?>
        <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
    <?php elseif (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="install.php" method="post">
        <label for="db_server">Servidor:</label>
        <input type="text" name="db_server" id="db_server" required value="localhost">

        <label for="db_port">Puerto:</label>
        <input type="text" name="db_port" id="db_port" required value="3306">

        <label for="db_username">Usuario:</label>
        <input type="text" name="db_username" id="db_username" required>

        <label for="db_password">Contraseña:</label>
        <input type="password" name="db_password" id="db_password">

        <label for="db_database">Base de datos:</label>
        <input type="text" name="db_database" id="db_database" required>

        <button type="submit">Instalar</button>
    </form>
</body>
</html>
