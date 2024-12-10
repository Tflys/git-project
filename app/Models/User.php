<?php

namespace App\Models;

use PDO;

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Registrar un nuevo usuario
    public function createUser($login, $password, $rol)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (login, password, rol) VALUES (:login, :password, :rol)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'login' => $login,
            'password' => $hashedPassword,
            'rol' => $rol
        ]);
    }

    // Obtener un usuario por su ID
    public function getUserById($id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener un usuario por su login
    public function getUserByLogin($login)
    {
        $sql = "SELECT * FROM usuarios WHERE login = :login";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar un usuario
    public function updateUser($id, $login, $password, $rol)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET login = :login, password = :password, rol = :rol WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'login' => $login,
            'password' => $hashedPassword,
            'rol' => $rol
        ]);
    }

    // Eliminar un usuario
    public function deleteUser($id)
    {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Verificar si un usuario existe con el login y la contraseña proporcionada
    public function verifyUser($login, $password)
    {
        $user = $this->getUserByLogin($login);
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Usuario válido
        }
        return null; // Usuario no encontrado o contraseña incorrecta
    }
}
