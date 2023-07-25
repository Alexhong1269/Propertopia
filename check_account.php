<?php
// check_credentials.php

// Assuming you have already set up the necessary MySQL credentials
$host = 'localhost';
$username = 'shong37';
$password = 'shong37';
$database = 'shong37';

// Establish a connection to the MySQL database
$conn = new mysqli($host, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Simple form validation
    if (empty($email) || empty($password)) {
        die("Error: Email and password are required.");
    }

    // Prepare and execute the SQL query to fetch the user with the provided email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User with the provided email exists in the database, now check the password
        $user = $result->fetch_assoc();
        $stored_password = $user["password"];

        // Verify the password using password_verify function
        if (password_verify($password, $stored_password)) {
            // Passwords match, user is authenticated
            echo "Login successful!";
            // You can perform additional actions here like redirecting the user to a dashboard or member area.
        } else {
            // Passwords do not match
            echo "Invalid password.";
        }
    } else {
        // User with the provided email does not exist in the database
        echo "User with this email does not exist.";
    }
}

// Close the database connection
$conn->close();
?>
