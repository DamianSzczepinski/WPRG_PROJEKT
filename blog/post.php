<?php

require 'config.php';
session_start();

$postId = $_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM posts WHERE id = ?');
$stmt->execute([$postId]);
$post = $stmt->fetch();

$stmt = $pdo->prepare('SELECT comments.*, users.username FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE post_id = ? ORDER BY created_at DESC');
$stmt->execute([$postId]);
$comments = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'];
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    $stmt = $pdo->prepare('INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)');
    $stmt->execute([$postId, $userId, $content]);

    header("Location: post.php?id=$postId");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link rel="stylesheet" type="text/css" href="style4.css">
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($post['title']); ?></h1>
        <p><?php echo htmlspecialchars($post['content']); ?></p>
        <?php if ($post['image_path']): ?>
            <img src="<?php echo htmlspecialchars($post['image_path']); ?>" alt="Obrazek do wpisu">
        <?php endif; ?>
        <p>Opublikowano <?php echo htmlspecialchars($post['created_at']); ?></p>

        <h2>Komentarze</h2>
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <p><?php echo htmlspecialchars($comment['content']); ?></p>
                <p>Przez <?php echo htmlspecialchars($comment['username'] ?? 'Gość'); ?> dnia <?php echo htmlspecialchars($comment['created_at']); ?></p>
            </div>
        <?php endforeach; ?>

        <h3>Dodaj komentarz</h3>
        <form method="post">
            <textarea name="content" placeholder="Twój komentarz" required></textarea>
            <button type="submit">Dodaj komentarz</button>
        </form>
    </div>
</body>
</html>
