<?php
// save_data.php

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

// Function to check if a string contains any numbers
function containsNumbers($str) {
    return preg_match('/\d/', $str) === 1;
}

// Function to check if a string contains any special characters
function containsSpecialChars($str) {
    return preg_match('/[^A-Za-z0-9]/', $str) === 1;
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Simple form validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        die("Error: All fields are required.");
    }

    // Additional validation for first name
    if (containsNumbers($first_name) || containsSpecialChars($first_name)) {
        die("Error: First name cannot contain numbers or special characters.");
    }

    // Additional validation for last name
    if (containsNumbers($last_name) || containsSpecialChars($last_name)) {
        die("Error: Last name cannot contain numbers or special characters.");
    }

    // Hash the password using bcrypt algorithm
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Prepare and execute the SQL query to create the table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS USERS (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL,
        password VARCHAR(255) NOT NULL
    )";

    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table: " . $conn->error;
        exit();
    }

    // Prepare and execute the SQL query to insert user data
    $stmt = $conn->prepare("INSERT INTO USERS (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

    if ($stmt->execute()) {
        // Data saved successfully, now redirect to the sign-in page
        header("Location: ./signin.html");
        exit(); // Make sure to exit after the redirect
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>




