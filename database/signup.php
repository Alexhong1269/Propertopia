<?php
$host = "localhost";
$username = "wlee46";
$password = "wlee46";
$database = "wlee46";

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to create the users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'buyer', 'seller') NOT NULL
  )";

// Execute the query to create the users table
if ($conn->query($sql) === TRUE) {
    echo "Table users created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}

// Function to safely handle user inputs (prevent SQL injection)
function sanitizeInput($input)
{
    global $conn;
    return mysqli_real_escape_string($conn, $input);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = sanitizeInput($_POST["firstname"]);
    $lastName = sanitizeInput($_POST["lastname"]);
    $email = sanitizeInput($_POST["email"]);
    $password = $_POST["password"];
    $role = $_POST["user_option"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into the database
    $insert_sql = "INSERT INTO users (first_name, last_name, email, password, role)
            VALUES ('$firstName', '$lastName', '$email', '$hashedPassword', '$role')";

    if ($conn->query($insert_sql) === TRUE) {
        echo "Data inserted successfully.";
        header("Location: ../signin.html");
    } else {
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>