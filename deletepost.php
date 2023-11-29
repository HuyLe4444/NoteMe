<?php
include('config.php');

// Get the post ID to delete
$post_id = $_POST['post_id'];

// Delete post query
$query = "DELETE FROM posts WHERE id = :id";
$stmt = $con->prepare($query);
$stmt->bindParam(':id', $post_id); 
$stmt->execute();

header('Location: home.php');

?>