<?php

namespace App\Models;

use PDO;

class Book
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Crear un nuevo libro
    public function createBook($titulo, $autor_id, $genero, $numero_copias, $numero_paginas)
    {
        $sql = "INSERT INTO libros (titulo, autor_id, genero, numero_copias, numero_paginas) VALUES (:titulo, :autor_id, :genero, :numero_copias, :numero_paginas)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'titulo' => $titulo,
            'autor_id' => $autor_id,
            'genero' => $genero,
            'numero_copias' => $numero_copias,
            'numero_paginas' => $numero_paginas
        ]);
    }

    // Obtener todos los libros
    public function getAllBooks()
    {
        $sql = "SELECT * FROM libros";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un libro por su ID
    public function getBookById($id)
    {
        $sql = "SELECT * FROM libros WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar un libro
    public function updateBook($id, $titulo, $autor_id, $genero, $numero_copias, $numero_paginas)
    {
        $sql = "UPDATE libros SET titulo = :titulo, autor_id = :autor_id, genero = :genero, numero_copias = :numero_copias, numero_paginas = :numero_paginas WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'titulo' => $titulo,
            'autor_id' => $autor_id,
            'genero' => $genero,
            'numero_copias' => $numero_copias,
            'numero_paginas' => $numero_paginas
        ]);
    }

    // Eliminar un libro
    public function deleteBook($id)
    {
        $sql = "DELETE FROM libros WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Buscar libros por título
    public function searchBooksByTitle($titulo)
    {
        $sql = "SELECT * FROM libros WHERE titulo LIKE :titulo";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['titulo' => '%' . $titulo . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
