<?php
use App\Models\Book;

if (isset($book)) {
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Libro</title>
    <link rel="stylesheet" href="/public/styles.css">
</head>
<body>
    <h1>Eliminar Libro</h1>

    <p>¿Estás seguro de que quieres eliminar el libro "<?php echo htmlspecialchars($book['titulo']); ?>"?</p>

    <form action="/books/destroy.php" method="post">
        <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
        <button type="submit">Sí, eliminar</button>
    </form>

    <a href="/books/list.php">Cancelar</a>

</body>
</html>

<?php
} else {
    echo "Libro no encontrado.";
}
?>
