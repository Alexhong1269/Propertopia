<?php
session_start();
// check_credentials.php

// Assuming you have already set up the necessary MySQL credentials
$host = 'localhost';
$username = 'wlee46';
$password = 'wlee46';
$database = 'wlee46';

// Establish a connection to the MySQL database
$conn = new mysqli($host, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to safely handle user inputs (prevent SQL injection)
function sanitizeInput($input)
{
    global $conn;
    return mysqli_real_escape_string($conn, $input);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitizeInput($_POST["email"]);
    $password = $_POST["password"];

    // Simple form validation
    if (empty($email) || empty($password)) {
        die("Error: Email and password are required.");
    }

    // Prepare and execute the SQL query to fetch the user with the provided email
    $select_sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = $conn->query($select_sql);

    if ($result->num_rows == 1) {
        // User with the provided email exists in the database, now check the password
        $user = $result->fetch_assoc();
        $hashedPassword = $user["password"];


        // Verify the password using password_verify function
        if (password_verify($password, $hashedPassword)) {

            // Store user's first name and last name in PHP sessions
            session_start();
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['user_id'] = $user['id'];
            // Passwords match, user is authenticated
            if ($user['role'] === 'seller') {
                header("Location: seller_dashboard.php");
                exit();
            }
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