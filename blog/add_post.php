<?php
require 'config.php';
session_start();

if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'author') {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $imagePath = '';

    if (!empty($_FILES['image']['name'])) {
        $imagePath = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    $stmt = $pdo->prepare('INSERT INTO posts (title, content, image_path) VALUES (?, ?, ?)');
    $stmt->execute([$title, $content, $imagePath]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dodaj wpis</title>
    <link rel="stylesheet" type="text/css" href="style5.css">
</head>
<body>
    <div class="container">
        <h1>Dodaj wpis</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Tytuł" required>
            <textarea name="content" placeholder="Treść" required></textarea>
            <input type="file" name="image">
            <button type="submit">Dodaj wpis</button>
        </form>
    </div>
</body>
</html>
