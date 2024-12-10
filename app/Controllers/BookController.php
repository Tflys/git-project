<?php

require_once 'config/Database.php';

class BookController {
    private $db;
    private $pdo;

    public function __construct() {
        $this->db = new Database();
        $this->pdo = $this->db->connect();
    }

    /**
     * Listar todos los libros en la base de datos.
     *
     * @return array Lista de libros.
     */
    public function listBooks() {
        $stmt = $this->pdo->query("SELECT * FROM libros");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Inserta un nuevo libro en la base de datos.
     *
     * @param string $titulo El título del libro.
     * @param string $genero El género del libro.
     * @param int $autor_id El ID del autor del libro.
     * @return bool Retorna true si la inserción es exitosa, de lo contrario false.
     */
    public function insertBook($titulo, $genero, $autor_id) {
        $sql = "INSERT INTO libros (titulo, genero, autor_id) VALUES (:titulo, :genero, :autor_id)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':titulo' => $titulo,
            ':genero' => $genero,
            ':autor_id' => $autor_id
        ]);
    }

    /**
     * Edita un libro existente.
     *
     * @param int $id El ID del libro.
     * @param string $titulo El nuevo título del libro.
     * @param string $genero El nuevo género del libro.
     * @param int $autor_id El nuevo ID del autor.
     * @return bool Retorna true si la actualización es exitosa, de lo contrario false.
     */
    public function editBook($id, $titulo, $genero, $autor_id) {
        $sql = "UPDATE libros SET titulo = :titulo, genero = :genero, autor_id = :autor_id WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':titulo' => $titulo,
            ':genero' => $genero,
            ':autor_id' => $autor_id
        ]);
    }

    /**
     * Elimina un libro de la base de datos.
     *
     * @param int $id El ID del libro a eliminar.
     * @return bool Retorna true si la eliminación es exitosa, de lo contrario false.
     */
    public function deleteBook($id) {
        $sql = "DELETE FROM libros WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
