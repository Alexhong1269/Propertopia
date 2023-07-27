<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
var_dump($_POST);
var_dump($_FILES);

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
        image_filename VARCHAR(255),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";

    if ($conn->query($table_query) === TRUE) {
        echo "Table properties created successfully.";
    } else {
        echo "Error creating table: " . $conn->error;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] === "delete") {
    $propertyId = $_POST["property_id"];

    // Delete the property from the database
    $delete_query = "DELETE FROM properties WHERE id = $propertyId";
    if ($conn->query($delete_query) === TRUE) {
        echo "Property deleted successfully.";
    } else {
        echo "Error deleting property: " . $conn->error;
    }

    exit; // Prevent the rest of the code from executing when performing the deletion.
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

    // Handle image input
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["image_file"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["image_file"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image";
        exit;
    }
    if (!in_array($imageFileType, array("jpg", "jpeg", "png", "gif"))) {
        echo "Only JPG, JPEG, PNG, and GIF files are allowed";
        exit;
    }
    if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
        echo "Image uploaded successfully.";
    } else {
        echo "Error uploaidng image.";
        exit;
    }


    // Insert data into the database
    $image_filename = basename($_FILES["image_file"]["name"]);

    $insert_query = "INSERT INTO properties (user_id, location, age, floor_plan, number_of_bedrooms, bathrooms, garden, parking, proximity_to_towns, proximity_to_roads, image_filename)
                     VALUES ('$user_id','$location', '$age', '$floor_plan', '$number_of_bedrooms', '$bathrooms', '$garden', '$parking', '$proximity_to_towns', '$proximity_to_roads', '$image_filename')";


    if ($conn->query($insert_query) === TRUE) {
        echo "Data inserted successfully.";
        header("Location: ./new_listing.html");
    } else {
        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }

}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] === "update") {
    $propertyId = $_POST["property_id"];
    // Retrieve form data for updating
    $location = $_POST["location"];
    $age = $_POST["age"];
    $floor_plan = $_POST["floor_plan"];
    $number_of_bedrooms = $_POST["number_of_bedrooms"];
    $bathrooms = $_POST["bathrooms"];
    $garden = isset($_POST["garden"]) ? 1 : 0;
    $parking = $_POST["parking"];
    $proximity_to_towns = $_POST["proximity_to_towns"];
    $proximity_to_roads = $_POST["proximity_to_roads"];

    // Check if the property ID exists in the database
    $check_property_query = "SELECT id FROM properties WHERE id = $propertyId";
    $result = $conn->query($check_property_query);

    if ($result->num_rows != 1) {
        echo "Property not found.";
        exit;
    }

    // Update the property data in the database
    $update_query = "UPDATE properties SET
        location = '$location',
        age = '$age',
        floor_plan = '$floor_plan',
        number_of_bedrooms = '$number_of_bedrooms',
        bathrooms = '$bathrooms',
        garden = '$garden',
        parking = '$parking',
        proximity_to_towns = '$proximity_to_towns',
        proximity_to_roads = '$proximity_to_roads'
        WHERE id = $propertyId";

    if ($conn->query($update_query) === TRUE) {
        echo "Property updated successfully.";
    } else {
        echo "Error updating property: " . $conn->error;
    }

    exit; // Prevent the rest of the code from executing when performing the update.
}




$conn->close();
?>