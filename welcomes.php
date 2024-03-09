<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: index.html"); // Redirect to login page if not logged in
    exit();
}

// Retrieve user ID from session
$user_id = $_SESSION["user_id"];

// You can fetch additional user information from the database if needed
// Connect to MySQL database
$conn = new mysqli("localhost", "root", "02091431", "user registration");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement to retrieve user data from the database
$stmt = $conn->prepare("SELECT firstname, lastname FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch user data
$row = $result->fetch_assoc();
$firstname = $row["firstname"];
$lastname = $row["lastname"];

// Close statement and database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
</head>
<body>
  <h2>Welcome, <?php echo $firstname . " " . $lastname; ?>!</h2>
</body>
</html>
