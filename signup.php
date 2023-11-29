<?php
session_start();
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    try {
        // Check if the username is already taken
        $stmt = $con->prepare("SELECT * FROM registration WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Username is already taken
            echo "<div class='message'>
                    <p>This username is already taken. Please choose another one.</p>
                  </div>";
        } else {
            // Username is unique, insert into the database
            $stmt = $con->prepare("INSERT INTO registration (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);

            $stmt->execute();

            header("Location: login.php");
            // Registration successful message
            echo "<div class='message'>
                    <p>Registration successful! You can now login.</p>
                  </div>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!-- HTML for signup form -->
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
                Sign Up
            </h1>
        </div>
        <div>
            <label for="username">Username</label> <br>
            <input type="text" name="username" id="username" placeholder="Username" required>
        </div>

        <div>
            <label for="email">Email</label> <br>
            <input type="email" name="email" id="email" placeholder="Email" required>
        </div>

        <div>
            <label for="password">Password</label> <br>
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>

        <div>
            <p>
                <b>Already have Account? </b><a href="login.php"><b>Log In</b></a>
            </p>
        </div>

        <div>
            <button type="submit"><b>Sign Up</b></button>
        </div>
    </form>

</body>
</html>
