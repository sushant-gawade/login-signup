<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

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

$user_id = $_SESSION['user_id'];

// Get form data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$gender = $_POST['gender'];
$mobile_no = $_POST['mobile_no'];

// Update user information in the database
$sql = "UPDATE users SET first_name='$first_name', last_name='$last_name', gender='$gender', mobile_no='$mobile_no' WHERE id=$user_id";

if ($conn->query($sql) === TRUE) {
    echo "Information updated successfully!";
} else {
    echo "Error updating information: " . $conn->error;
}

$conn->close();
?>
