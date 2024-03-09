<?php
// Check if the registration form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Error: Passwords do not match";
    } else {
    
// Connect to MySQL database
$conn = new mysqli("localhost", "root", "02091431", "user registration");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement to insert user data into the database
        $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $firstname, $lastname, $email, $hashed_password);

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "You have registered successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and database connection
        $stmt->close();
        $conn->close();
    }
}
?>
