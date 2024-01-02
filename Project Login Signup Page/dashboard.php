<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Get user details from the database based on the session user_id
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id=$user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Display user details on the dashboard
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>User Dashboard</title>";
    echo "<style>";
    echo "body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; display: flex; align-items: center; justify-content: center; height: 100vh; }";
    echo "form { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); max-width: 400px; width: 100%; box-sizing: border-box; }";
    echo "h2 { text-align: center; color: #333; }";
    echo "label { display: block; margin: 10px 0 5px; color: #555; }";
    echo "input, select { width: 100%; padding: 8px; margin-bottom: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }";
    echo "input[type='submit'] { background-color: #4caf50; color: #fff; cursor: pointer; }";
    echo "input[type='submit']:hover { background-color: #45a049; }";
    echo "</style>";
    echo "</head>";
    echo "<body>";
    echo "<form action='update_user.php' method='post'>";
    echo "<h2>Welcome, {$user['first_name']} {$user['last_name']}!</h2>";
    echo "<p>Email: {$user['email']}</p>";
    echo "<p>Gender: {$user['gender']}</p>";
    echo "<p>Mobile No: {$user['mobile_no']}</p>";

    // Update Form
    echo "<h3>Update Information</h3>";
    echo "<label for='first_name'>First Name:</label>";
    echo "<input type='text' name='first_name' value='{$user['first_name']}' required><br>";

    echo "<label for='last_name'>Last Name:</label>";
    echo "<input type='text' name='last_name' value='{$user['last_name']}' required><br>";

    echo "<label for='gender'>Gender:</label>";
    echo "<select name='gender' required>";
    echo "<option value='male' " . ($user['gender'] == 'male' ? 'selected' : '') . ">Male</option>";
    echo "<option value='female' " . ($user['gender'] == 'female' ? 'selected' : '') . ">Female</option>";
    echo "<option value='other' " . ($user['gender'] == 'other' ? 'selected' : '') . ">Other</option>";
    echo "</select><br>";

    echo "<label for='mobile_no'>Mobile No:</label>";
    echo "<input type='text' name='mobile_no' value='{$user['mobile_no']}' required><br>";

    echo "<input type='submit' value='Update'>";
    echo "</form>";

    // Add more details as needed
    echo "</body>";
    echo "</html>";
} else {
    echo "User not found";
}

$conn->close();
?>
