<?php
require_once 'controllers/AuthController.php';
require_once 'controllers/AuthorController.php';

$auth = new AuthController();
$auth->redirectIfNotAuthenticated();

$rol = $_SESSION['rol'] ?? '';
if ($rol !== 'admin') {
    header('Location: /index.php');
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /views/authors/list.php?error=Invalid ID');
    exit();
}

$id = (int)$_GET['id'];
$authorController = new AuthorController();

if ($authorController->deleteAuthor($id)) {
    header('Location: /views/authors/list.php?success=Author deleted successfully');
    exit();
} else {
    header('Location: /views/authors/list.php?error=Failed to delete author');
    exit();
}
