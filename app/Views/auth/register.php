<?php
// Incluimos el archivo de configuración y el archivo para la conexión a la base de datos
require_once '../../config/config.php';
require_once '../../config/database.php';

// Inicializamos la conexión con la base de datos
$pdo = Database::getConnection();

// Procesar el formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);
    
    $errores = [];

    // Validaciones
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido.";
    }

    if (empty($password)) {
        $errores[] = "La contraseña es obligatoria.";
    } elseif ($password !== $confirmPassword) {
        $errores[] = "Las contraseñas no coinciden.";
    }

    // Verificar si el email ya está registrado
    if (empty($errores)) {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);

        if ($stmt->rowCount() > 0) {
            $errores[] = "El correo electrónico ya está registrado.";
        }
    }

    // Si no hay errores, insertamos al nuevo usuario
    if (empty($errores)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)");
        $result = $stmt->execute([
            'nombre' => $nombre,
            'email' => $email,
            'password' => $hashedPassword,
        ]);

        if ($result) {
            header("Location: login.php?registro=exitoso");
            exit;
        } else {
            $errores[] = "Hubo un error al registrar el usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../../public/styles.css">
</head>
<body>
    <h1>Registro de Usuario</h1>

    <?php if (!empty($errores)): ?>
        <div style="color: red;">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="register.php" method="post">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirmar Contraseña</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit">Registrar</button>
    </form>

    <script>
    document.querySelector('form').addEventListener('submit', function(event) {
        var nombre = document.getElementById('nombre').value.trim();
        var email = document.getElementById('email').value.trim();
        var password = document.getElementById('password').value.trim();
        var confirmPassword = document.getElementById('confirm_password').value.trim();
        var errores = [];

        if (nombre === '') {
            errores.push("El nombre es obligatorio.");
        }

        if (email === '' || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            errores.push("El email no es válido.");
        }

        if (password === '') {
            errores.push("La contraseña es obligatoria.");
        } else if (password !== confirmPassword) {
            errores.push("Las contraseñas no coinciden.");
        }

        if (errores.length > 0) {
            event.preventDefault();
            var errorDiv = document.createElement('div');
            errorDiv.style.color = 'red';
            var errorList = document.createElement('ul');
            errores.forEach(function(error) {
                var listItem = document.createElement('li');
                listItem.textContent = error;
                errorList.appendChild(listItem);
            });
            errorDiv.appendChild(errorList);
            document.body.insertBefore(errorDiv, document.querySelector('form'));
        }
    });
    </script>

    <footer>
        <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
    </footer>
</body>
</html>
