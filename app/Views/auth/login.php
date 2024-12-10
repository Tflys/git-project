<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <script>
        function validarFormulario() {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();

            if (username.length < 4) {
                alert('El nombre de usuario debe tener al menos 4 caracteres.');
                return false;
            }

            if (password.length < 6) {
                alert('La contraseña debe tener al menos 6 caracteres.');
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="login-container">
        <h1>Iniciar Sesión</h1>

        <?php if (!empty($error)): ?>
            <div class="error-message">
                <p><?php echo htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>

        <form action="/auth/login" method="POST" onsubmit="return validarFormulario()">
            <div class="form-group">
                <label for="username">Usuario</label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    required 
                    minlength="4"
                    placeholder="Escribe tu usuario">
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    required 
                    minlength="6"
                    placeholder="Escribe tu contraseña">
            </div>

            <button type="submit" class="btn-primary">Entrar</button>
        </form>

        <p>¿No tienes una cuenta? <a href="/auth/register">Regístrate aquí</a></p>
    </div>
</body>
</html>
