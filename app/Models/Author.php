<?php

namespace App\Models; // Definir un espacio de nombres para la clase

use PDO;

class Author
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Obtener todos los autores
    public function getAllAuthors()
    {
        $sql = "SELECT * FROM autores";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un autor por su ID
    public function getAuthorById($id)
    {
        $sql = "SELECT * FROM autores WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insertar un nuevo autor
    public function createAuthor($nombre, $apellido, $nacionalidad)
    {
        $sql = "INSERT INTO autores (nombre, apellido, nacionalidad) VALUES (:nombre, :apellido, :nacionalidad)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'nombre' => $nombre,
            'apellido' => $apellido,
            'nacionalidad' => $nacionalidad
        ]);
    }

    // Actualizar un autor
    public function updateAuthor($id, $nombre, $apellido, $nacionalidad)
    {
        $sql = "UPDATE autores SET nombre = :nombre, apellido = :apellido, nacionalidad = :nacionalidad WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'nacionalidad' => $nacionalidad
        ]);
    }

    // Eliminar un autor
    public function deleteAuthor($id)
    {
        $sql = "DELETE FROM autores WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
