<?php
// Start session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Connect to MySQL database
    $conn = new mysqli("localhost", "root", "02091431", "user registration");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to retrieve user data from the database
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row["password"])) {
            // Password is correct, start a new session
            session_regenerate_id();
            $_SESSION["user_id"] = $row["id"];
            header("Location: welcomes.php"); // Redirect to welcome page
            exit();
        } else {
            // Password is incorrect
            echo "Invalid email or password.";
        }
    } else {
        // User does not exist
        echo "Please register.";
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}
?>
