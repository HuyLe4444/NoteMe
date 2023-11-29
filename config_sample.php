<?php
$host = "localhost";
$dbname = "database_name_here"; // <-- Fill in
$username = "root";
$password = "password_here"; // <-- Fill in

try {
    $con = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>