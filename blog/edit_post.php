<?php
require 'config.php';
session_start();


if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'author')) {
    header('Location: index.php');
    exit;
}


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Nieprawidłowy identyfikator wpisu.";
    exit;
}

$postId = $_GET['id'];


$stmt = $pdo->prepare('SELECT * FROM posts WHERE id = ?');
$stmt->execute([$postId]);
$post = $stmt->fetch();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $imagePath = $post['image_path'];

  
    if (!empty($_FILES['image']['name'])) {
        $imagePath = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }


    $stmt = $pdo->prepare('UPDATE posts SET title = ?, content = ?, image_path = ? WHERE id = ?');
    $stmt->execute([$title, $content, $imagePath, $postId]);


    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edytuj wpis</title>
</head>
<body>
    <h1>Edytuj wpis</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
        <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>
        <input type="file" name="image">
        <button type="submit">Zaktualizuj wpis</button>
    </form>
</body>
</html>
