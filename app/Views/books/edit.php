<?php
use App\Models\Book;

if (isset($book)) {
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Libro</title>
    <link rel="stylesheet" href="/public/styles.css">
</head>
<body>
    <h1>Editar Libro</h1>

    <form action="/books/update.php" method="post">
        <input type="hidden" name="id" value="<?php echo $book['id']; ?>">

        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo" value="<?php echo htmlspecialchars($book['titulo']); ?>" required>

        <label for="autor_id">Autor ID</label>
        <input type="number" name="autor_id" id="autor_id" value="<?php echo htmlspecialchars($book['autor_id']); ?>" required>

        <label for="genero">Género</label>
        <input type="text" name="genero" id="genero" value="<?php echo htmlspecialchars($book['genero']); ?>" required>

        <label for="numero_copias">Número de Copias</label>
        <input type="number" name="numero_copias" id="numero_copias" value="<?php echo htmlspecialchars($book['numero_copias']); ?>" required>

        <label for="numero_paginas">Número de Páginas</label>
        <input type="number" name="numero_paginas" id="numero_paginas" value="<?php echo htmlspecialchars($book['numero_paginas']); ?>" required>

        <button type="submit">Actualizar Libro</button>
    </form>

</body>
</html>

<?php
} else {
    echo "Libro no encontrado.";
}
?>
