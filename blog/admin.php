<?php
require 'config.php';
session_start();

if ($_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->query('SELECT * FROM posts ORDER BY created_at DESC');
$posts = $stmt->fetchAll();

$stmt = $pdo->query('SELECT * FROM users');
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel administracyjny</title>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>
<body>
    <div class="container">
        <h1>Panel administracyjny</h1>
        
        <h2>Wpisy</h2>
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                <p><?php echo htmlspecialchars($post['content']); ?></p>
                <a href="edit_post.php?id=<?php echo $post['id']; ?>">Edytuj</a>
                <a href="delete_post.php?id=<?php echo $post['id']; ?>">Usuń</a>
            </div>
        <?php endforeach; ?>

        <h2>Użytkownicy</h2>
        <?php foreach ($users as $user): ?>
            <div class="user">
                <p><?php echo htmlspecialchars($user['username']); ?> (<?php echo htmlspecialchars($user['role']); ?>)</p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
