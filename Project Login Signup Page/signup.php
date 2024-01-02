<?php
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
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$gender = $_POST['gender'];
$mobile_no = $_POST['mobile_no'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

// Insert data into database
$sql = "INSERT INTO users (first_name, last_name, gender, mobile_no, email, password)
        VALUES ('$first_name', '$last_name', '$gender', '$mobile_no', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Sign up successful!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
