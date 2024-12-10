<?php

require_once 'config/Database.php';

class AuthorController {
    private $db;
    private $pdo;

    public function __construct() {
        $this->db = new Database();
        $this->pdo = $this->db->connect();
    }

    /**
     * Listar todos los autores en la base de datos.
     *
     * @return array Lista de autores.
     */
    public function listAuthors() {
        $stmt = $this->pdo->query("SELECT * FROM autores");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Inserta un nuevo autor en la base de datos.
     *
     * @param string $nombre El nombre del autor.
     * @param string $apellidos Los apellidos del autor.
     * @return bool Retorna true si la inserción es exitosa, de lo contrario false.
     */
    public function insertAuthor($nombre, $apellidos) {
        $sql = "INSERT INTO autores (nombre, apellidos) VALUES (:nombre, :apellidos)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':apellidos' => $apellidos
        ]);
    }

    /**
     * Edita un autor existente.
     *
     * @param int $id El ID del autor.
     * @param string $nombre El nuevo nombre del autor.
     * @param string $apellidos Los nuevos apellidos del autor.
     * @return bool Retorna true si la actualización es exitosa, de lo contrario false.
     */
    public function editAuthor($id, $nombre, $apellidos) {
        $sql = "UPDATE autores SET nombre = :nombre, apellidos = :apellidos WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':apellidos' => $apellidos
            
        ]);
    }

    /**
     * Elimina un autor de la base de datos.
     *
     * @param int $id El ID del autor a eliminar.
     * @return bool Retorna true si la eliminación es exitosa, de lo contrario false.
     */
    public function deleteAuthor($id) {
        $sql = "DELETE FROM autores WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function updateAuthor($id, $nombre, $apellidos, $nacionalidad) {
        $sql = "UPDATE autores SET nombre = :nombre, apellidos = :apellidos, nacionalidad = :nacionalidad WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
    
        return $stmt->execute([
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'nacionalidad' => $nacionalidad,
            'id' => $id
        ]);
    }
    
}
