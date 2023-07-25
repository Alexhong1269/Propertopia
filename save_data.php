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

    // Prepare and execute the SQL query
    $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Data saved successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
