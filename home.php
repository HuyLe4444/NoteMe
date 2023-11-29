<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Include the database connection configuration
include("config.php");

// Fetch and display blog posts for the current user only
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM posts WHERE user_id = :user_id ORDER BY created_at DESC";
$stmt = $con->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

// Check for query execution error
if (!$stmt) {
    die("Query failed: " . $con->errorInfo()[2]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>NoteMe</title>
</head>
<body>
    <h1><p>Welcome, <?php echo $_SESSION["username"]; ?>!</p></h1>
    <h1><a href="logout.php"><button>Log Out</button></a></h1>

    <h2>Create a New Note</h2>
    <form action="newpost.php" method="post">
        <label for="title">Title:</label>
        <input type="text" name="title" placeholder="Title" required>

        <label for="content">Content:</label> <br>
        <textarea name="content" cols="58" rows="4" required placeholder="Type here..."></textarea>

        <button type="submit">Submit Post</button>
    </form>

    <h2>Your Notes</h2>
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
    <div class="blog-post">
        <h3><?php echo $row['title']; ?></h3>
        <p><?php echo $row['content']; ?></p>
        <p>Published on: <?php echo $row['created_at']; ?></p>
        <form action="deletepost.php" method="post" class="delete-button">
            <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
            <button type="submit" class="custom-delete-button">Delete</button> 
        </form> 
    </div>
<?php endwhile; ?>
</body>

<footer>
    <h1>
        <p>&copy; 2023 Huy Le. All rights reserved.</p>
    </h1>
</footer>
</html>
