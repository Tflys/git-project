<?php
use App\Models\Book;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Libros</title>
    <link rel="stylesheet" href="/public/styles.css">
</head>
<body>
    <h1>Listado de Libros</h1>

    <a href="/books/create.php">Agregar nuevo libro</a>

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Género</th>
                <th>Número de Copias</th>
                <th>Número de Páginas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
            <tr>
                <td><?php echo htmlspecialchars($book['titulo']); ?></td>
                <td><?php echo htmlspecialchars($book['autor_id']); // Puedes añadir el nombre del autor ?></td>
                <td><?php echo htmlspecialchars($book['genero']); ?></td>
                <td><?php echo htmlspecialchars($book['numero_copias']); ?></td>
                <td><?php echo htmlspecialchars($book['numero_paginas']); ?></td>
                <td>
                    <a href="/books/edit.php?id=<?php echo $book['id']; ?>">Editar</a> | 
                    <a href="/books/delete.php?id=<?php echo $book['id']; ?>">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
