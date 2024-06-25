<?php

require 'config.php';
session_start();


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

if (!isset($_GET['id'])) {
    echo "No post ID provided.";
    exit;
}

$id = $_GET['id'];

$sql = "DELETE FROM posts WHERE id = :id";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([':id' => $id])) {
    header('Location: admin.php');
    exit;
} else {
    echo "Error deleting post.";
    exit;
}
?>
