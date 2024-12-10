<?php

namespace App\Controllers; // Definir un espacio de nombres para la clase

use App\Models\User;
use App\Database;

class UserController
{
    private $db;
    private $userModel;

    public function __construct()
    {
        // Iniciar la conexión a la base de datos
        $this->db = Database::getConnection();
        $this->userModel = new User($this->db);
    }

    // Acción para mostrar el formulario de registro
    public function showRegisterForm()
    {
        require_once __DIR__ . '/../Views/auth/register.php';
    }

    // Acción para procesar el formulario de registro
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirmPassword = trim($_POST['confirm_password']);

            // Validar los datos
            $errores = [];

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

            // Si no hay errores, intentar registrar al usuario
            if (empty($errores)) {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                if ($this->userModel->registerUser($nombre, $email, $hashedPassword)) {
                    header("Location: /public/auth/login.php?registro=exitoso");
                    exit;
                } else {
                    $errores[] = "Hubo un error al registrar el usuario.";
                }
            }

            // Si hay errores, mostrar los mensajes
            require_once __DIR__ . '/../Views/auth/register.php';
        }
    }

    // Acción para mostrar el formulario de login
    public function showLoginForm()
    {
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    // Acción para procesar el login
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            // Validar los datos
            if (!empty($email) && !empty($password)) {
                $user = $this->userModel->loginUser($email);

                if ($user && password_verify($password, $user['password'])) {
                    session_start();
                    $_SESSION['user'] = $user['email'];
                    $_SESSION['rol'] = $user['rol'];
                    $_SESSION['user_id'] = $user['id'];
                    header("Location: /public/index.php");
                    exit;
                } else {
                    $error = "Las credenciales no son correctas.";
                }
            } else {
                $error = "Por favor, complete todos los campos.";
            }

            // Mostrar el login con el mensaje de error
            require_once __DIR__ . '/../Views/auth/login.php';
        }
    }

    // Acción para hacer logout
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /public/index.php");
        exit;
    }
}
