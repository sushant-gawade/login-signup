<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];

// Check user credentials
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        // Password is correct, redirect to dashboard
        $_SESSION['user_id'] = $row['id'];
        header("Location: dashboard.php");
    } else {
        echo "Invalid password";
    }
} else {
    echo "User not found";
}

$conn->close();
?>
