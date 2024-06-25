<?php
require 'config.php';
session_start();


$stmt = $pdo->query('SELECT * FROM posts ORDER BY created_at DESC');
$posts = $stmt->fetchAll();


if (isset($_SESSION['role']) && $_SESSION['role'] === 'user') {

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Blog</h1>
        
        <?php if (isset($_SESSION['username'])): ?>
            <p>Witaj, <?php echo htmlspecialchars($_SESSION['username']); ?> (<a href="logout.php">Wyloguj</a>)</p>
            
            <?php if ($_SESSION['role'] === 'user'): ?>
                <p><a href="add_comment.php">Dodaj komentarz</a></p>
            <?php elseif ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'author'): ?>
                <p><a href="add_post.php">Dodaj nowy wpis</a></p>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <p><a href="admin.php">Panel administracyjny</a></p>
                <?php endif; ?>
            <?php endif; ?>
            
        <?php else: ?>
            <p><a href="login.php">Zaloguj się</a> | <a href="register.php">Zarejestruj się</a></p>
        <?php endif; ?>

        <?php foreach ($posts as $post): ?>
            <div class="post">
                <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                <p><?php echo htmlspecialchars($post['content']); ?></p>
                <?php if ($post['image_path']): ?>
                    <img src="<?php echo htmlspecialchars($post['image_path']); ?>" alt="Obrazek do wpisu">
                <?php endif; ?>
                <p class="published">Opublikowano <?php echo htmlspecialchars($post['created_at']); ?></p>
                <p><a href="post.php?id=<?php echo $post['id']; ?>">Czytaj więcej</a></p>
            </div>
        <?php endforeach; ?>

        <p class="contact">Kontakt do autora bloga: <a href="mailto:adres-email-autora@example.com">adres-email: Damiansz2003@gmail.com</a></p>
    </div>
</body>
</html>
