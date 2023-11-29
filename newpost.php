<?php
session_start();
include("config.php");

if (!isset($_SESSION['user_id'])) {
    die("user id not set in session");
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['title'], $_POST['content'])) {
    $title = $con->quote($_POST['title']);
    $content = $con->quote($_POST['content']);

    $query = "INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
    $stmt->bindParam(2, $title, PDO::PARAM_STR);
    $stmt->bindParam(3, $content, PDO::PARAM_STR);
    $stmt->execute();
    

    header("Location: home.php");
    $stmt->close();
    exit();
} else {
    header("Location: home.php");
    $stmt->close();
    exit();
}
?>
