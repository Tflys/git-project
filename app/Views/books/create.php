<?php
use App\Models\Book;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Libro</title>
    <link rel="stylesheet" href="/public/styles.css">
</head>
<body>
    <h1>Agregar Nuevo Libro</h1>

    <form action="/books/store.php" method="post">
        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo" required>

        <label for="autor_id">Autor ID</label>
        <input type="number" name="autor_id" id="autor_id" required>

        <label for="genero">Género</label>
        <input type="text" name="genero" id="genero" required>

        <label for="numero_copias">Número de Copias</label>
        <input type="number" name="numero_copias" id="numero_copias" required>

        <label for="numero_paginas">Número de Páginas</label>
        <input type="number" name="numero_paginas" id="numero_paginas" required>

        <button type="submit">Guardar Libro</button>
    </form>

</body>
</html>
