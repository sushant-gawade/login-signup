<?php
// Add necessary database connection code here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Check if the user with the given email exists
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];

        // Generate a unique token
        $token = bin2hex(random_bytes(32));

        // Set the token expiration time (e.g., 1 hour from now)
        $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Store the token in the database
        $sql = "INSERT INTO password_reset (user_id, token, expires_at) VALUES ($user_id, '$token', '$expires_at')";
        if ($conn->query($sql) === TRUE) {
            // Send an email to the user with a link containing the token
            $reset_link = "http://yourwebsite.com/reset_password_form.php?token=$token";
            // You can use PHPMailer or other email libraries for sending emails
            // Example: mail($email, "Password Reset", "Click the link to reset your password: $reset_link");

            echo "Password reset instructions sent to your email.";
        } else {
            echo "Error storing reset token: " . $conn->error;
        }
    } else {
        echo "User not found.";
    }
}

$conn->close();
?>
