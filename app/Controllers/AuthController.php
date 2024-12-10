<?php

class AuthController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    public function login() {
        // Si es una solicitud GET, mostrar el formulario de inicio de sesión.
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once 'views/auth/login.php';
            return;
        }

        // Si es una solicitud POST, procesar el formulario.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validaciones del lado del servidor
            $username = htmlspecialchars(trim($_POST['username'] ?? ''));
            $password = htmlspecialchars(trim($_POST['password'] ?? ''));

            if (empty($username) || empty($password)) {
                $error = 'Por favor, completa todos los campos.';
                require_once 'views/auth/login.php';
                return;
            }

            if (strlen($username) < 4 || strlen($password) < 6) {
                $error = 'El usuario debe tener al menos 4 caracteres y la contraseña al menos 6 caracteres.';
                require_once 'views/auth/login.php';
                return;
            }

            // Verificar las credenciales del usuario usando el modelo
            $user = $this->userModel->authenticate($username, $password);

            if ($user) {
                // Guardar los datos del usuario en la sesión
                session_start();
                $_SESSION['user'] = $user['username'];
                $_SESSION['rol'] = $user['rol'];

                // Redirigir a la página de inicio
                header('Location: /dashboard');
                exit;
            } else {
                // Credenciales incorrectas
                $error = 'Usuario o contraseña incorrectos.';
                require_once 'views/auth/login.php';
                return;
            }
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();

        // Redirigir al formulario de inicio de sesión
        header('Location: /auth/login');
        exit;
    }
}
