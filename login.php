<?php
session_start();
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        $stmt = $con->prepare("SELECT * FROM registration WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($user);

        // Verify the password using password_verify
        if ($user && password_verify($password, $user['password'])) {
            // Authentication successful
            $_SESSION["username"] = $user["username"];
            $_SESSION["user_id"] = $user["id"];
            header("Location: home.php");
            exit();
        } else {
            // Authentication failed
            echo "<div class='message'>
                    <p>Invalid username or password. Please try again.</p>
                  </div>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!-- HTML for login form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>NoteMe</title>
</head>
<body>
    <form action="" method="post">
        <div class="login-title">
            <h1>
                Login
            </h1>
        </div>
        <div>
            <label for="username">Username</label> <br>
            <input type="text" name="username" id="username" placeholder="Username" required>
        </div>
        
        <div>
            <label for="password">Password</label> <br>
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>

        <div>
            <p>
                <b>Don't have Account? </b> <a href="signup.php"><b>Sign Up</b></a>
            </p>
        </div>

        <div>
            <button type="submit"><b>Login</b></button>
        </div>
        
    </form>
    
</body>
</html>
