<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Database connection settings (replace with your actual details)
$db_host = "localhost";
$db_user = "wlee46";
$db_pass = "wlee46";
$db_name = "wlee46";

// Create a database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the "properties" table exists, and if not, create it
$user_id = $_SESSION['user_id'];
$check_user_query = "SELECT id FROM users WHERE id = $user_id";
$result = $conn->query($check_user_query);

if ($result->num_rows == 1) {
    $table_query = "CREATE TABLE IF NOT EXISTS properties (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(11) NOT NULL,
        location VARCHAR(255) NOT NULL,
        age VARCHAR(50) NOT NULL,
        floor_plan INT(11) NOT NULL,
        number_of_bedrooms INT(11) NOT NULL,
        bathrooms INT(11) NOT NULL,
        garden TINYINT(1) DEFAULT 0,
        parking VARCHAR(100) NOT NULL,
        proximity_to_towns VARCHAR(100) NOT NULL,
        proximity_to_roads VARCHAR(100) NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";

    if ($conn->query($table_query) === TRUE) {
        echo "Table users created successfully.";
    } else {
        echo "Error creating table: " . $conn->error;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Retrieve form data
    $user_id = $_SESSION['user_id'];
    $location = $_POST["location"];
    $age = $_POST["age"];
    $floor_plan = $_POST["floor_plan"];
    $number_of_bedrooms = $_POST["number_of_bedrooms"];
    $bathrooms = $_POST["bathrooms"];
    $garden = isset($_POST["garden"]) ? 1 : 0;
    $parking = $_POST["parking"];
    $proximity_to_towns = $_POST["proximity_to_towns"];
    $proximity_to_roads = $_POST["proximity_to_roads"];

    // Insert data into the database
    $insert_query = "INSERT INTO properties (user_id, location, age, floor_plan, number_of_bedrooms, bathrooms, garden, parking, proximity_to_towns, proximity_to_roads)
                     VALUES ('$user_id','$location', '$age', '$floor_plan', '$number_of_bedrooms', '$bathrooms', '$garden', '$parking', '$proximity_to_towns', '$proximity_to_roads')";


    if ($conn->query($insert_query) === TRUE) {
        echo "Data inserted successfully.";
    } else {
        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }

}

$conn->close();
?>