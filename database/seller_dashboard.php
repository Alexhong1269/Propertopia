<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Seller Dashboard</title>

</head>

<body>
    <style>
        .card_container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            flex-wrap: wrap;
        }

        .property_card {
            background-color: #757D75;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .delete_card {
            width: 30px;
            height: 30px;
        }

        .property_card,
        .new_property_card {
            padding: 20px;
            box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 30px;
            width: 300px;
            height: 400px;
        }

        h1 {
            text-align: center;
            margin-left: 10px;
            background-color: #343a40;
            color: white;
            padding: 30px;
            margin: 0;
        }


        #add {
            width: 40px;
            height: 40px;
        }

        #add:hover {
            cursor: pointer;
        }

        #modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 9999;
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: black;
            width: 800px;
        }

        .card_modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 9999;
        }

        .card_modal_content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: black;
            width: 800px;
        }

        form {
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            flex-direction: column;
            padding: 30px;
        }

        label {
            display: inline-block;
            width: 180px;
            text-align: left;
        }

        input {
            text-align: left;
        }

        #image_file {
            width: 152px;
        }

        .card_img {
            width: 120px;
            height: 120px;
        }

        .input_wrapper {
            margin: 3px auto;
        }

        #submit {
            text-align: center;
            margin: 10px auto;
        }
    </style>

    <?php

    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
    echo "<h1>Welcome, <span>{$username}</span>!</h1>";

    $db_host = "localhost";
    $db_user = "wlee46"; // Replace with your database username
    $db_pass = "wlee46"; // Replace with your database password
    $db_name = "wlee46"; // Replace with your database name
    
    // Create a database connection
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // function to retrieve property data from the db
    function getPropertiesData($conn, $user_id)
    {
        $select_query = "SELECT * FROM properties WHERE user_id = $user_id";
        $result = $conn->query($select_query);

        $propertiesData = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $propertiesData[] = $row;
            }
        }
        return $propertiesData;
    }
    $propertiesData = getPropertiesData($conn, $user_id);


    ?>
    <div class="container">
        <div class="card_container">
            <div class="property_card add_new">
                <p>Register a new property</p>
                <img src="../images/add_icon.png" id="add" alt="add_icon">
            </div>
            <?php foreach ($propertiesData as $property): ?>
                <div class="new_property_card" id="card_<?php echo $property['id'] ?>">
                    <div>
                        <img data-property-id="<?php echo $property['id'] ?>" src="../images/delete_icon.png" alt=""
                            class="delete_card">
                    </div>
                    <div>
                        <img src="../uploads/<?php echo $property['image_filename'] ?>" alt="" class="card_img">
                    </div>
                    <p>Location:
                        <?php echo $property['location']; ?>
                    </p>
                    <p>Age:
                        <?php echo $property['age']; ?>
                    </p>
                    <p>Floor plan:
                        <?php echo $property['floor_plan']; ?>
                    </p>
                    <button data-property-id="<?php echo $property['id'] ?>" class="detail_open">Details</button>
                </div>
                <div id="card_modal_<?php echo $property['id'] ?>" class="card_modal">
                    <div class="card_modal_content">
                        <div>
                            <img src="../uploads/<?php echo $property['image_filename'] ?>" alt="" class="card_img">
                        </div>
                        <p>Location:
                            <?php echo $property['location']; ?>
                        </p>
                        <p>Age:
                            <?php echo $property['age']; ?>
                        </p>
                        <p>Floor plan:
                            <?php echo $property['floor_plan']; ?>
                        </p>
                        <p>Number of bedrooms:
                            <?php echo $property['number_of_bedrooms']; ?>
                        </p>
                        <p>Number of bathrooms:
                            <?php echo $property['bathrooms']; ?>
                        </p>
                        <p>
                            Garden:
                            <?php echo $property['garden']; ?>
                        </p>
                        <p>
                            Parking:
                            <?php echo $property['parking']; ?>
                        </p>
                        <p>
                            Proximity to towns:
                            <?php echo $property['proximity_to_towns']; ?>
                        </p>
                        <p>
                            Proximity to roads:
                            <?php echo $property['proximity_to_roads']; ?>
                        </p>
                        <button data-property-id="<?php echo $property['id'] ?>" class="detail_close">Close</button>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div id="modal">
            <div class="modal-content">

                <form method="POST" action="./seller_db.php" id="property_form" enctype="multipart/form-data">
                    <div class="input_wrapper">
                        <label for="image_file">Image: </label>
                        <input type="file" id="image_file" name="image_file">
                    </div>
                    <div class="input_wrapper">
                        <label for="location">Location:</label>
                        <input type="text" id="location" name="location" required>
                    </div>
                    <div class="input_wrapper">
                        <label for="age">Age:</label>
                        <input type="text" id="age" name="age" required>
                    </div>

                    <div class="input_wrapper">
                        <label for="floor_plan">Floor Plan (in square feet):</label>
                        <input type="number" id="floor_plan" name="floor_plan" required>
                    </div>

                    <div class="input_wrapper">
                        <label for="number_of_bedrooms">Number of Bedrooms:</label>
                        <input type="number" id="number_of_bedrooms" name="number_of_bedrooms" required>
                    </div>


                    <div class="input_wrapper">
                        <label for="bathrooms">Number of Bathrooms:</label>
                        <input type="number" id="bathrooms" name="bathrooms" required>
                    </div>

                    <div class="input_wrapper">
                        <label for="garden">Garden:</label>
                        <input type="checkbox" id="garden" name="garden">
                    </div>


                    <div class="input_wrapper">
                        <label for="parking">Parking Availability:</label>
                        <input type="text" id="parking" name="parking" required>
                    </div>
                    <div class="input_wrapper">
                        <label for="proximity_to_towns">Proximity to Towns:</label>
                        <input type="text" id="proximity_to_towns" name="proximity_to_towns" required>
                    </div>

                    <div class="input_wrapper">
                        <label for="proximity_to_roads">Proximity to Roads:</label>
                        <input type="text" id="proximity_to_roads" name="proximity_to_roads" required>
                    </div>
                    <input type="submit" name="submit" value="submit" id="submit">
                </form>

            </div>
        </div>

    </div>


    <script>
        const add_icon = document.getElementById("add");
        const property_modal = document.getElementById("modal");
        const detail_open_buttons = document.querySelectorAll('.detail_open');
        const detail_close_buttons = document.querySelectorAll('.detail_close');
        const delete_card = document.querySelectorAll('.delete_card');

        console.log(detail_open_buttons);
        console.log(detail_close_buttons);

        add_icon.addEventListener("click", () => {
            property_modal.style.display = "block";
        });

        detail_open_buttons.forEach(button => {
            button.addEventListener("click", () => {
                const propertyId = button.getAttribute("data-property-id");
                const card_modal = document.getElementById(`card_modal_${propertyId}`);
                console.log(propertyId);
                card_modal.style.display = "block";
            })
        })

        detail_close_buttons.forEach(button => {
            button.addEventListener("click", () => {
                const propertyId = button.getAttribute("data-property-id");
                const card_modal = document.getElementById(`card_modal_${propertyId}`);
                console.log(card_modal);
                card_modal.style.display = "none";
            })
        })

        delete_card.forEach(icon => {
            icon.addEventListener('click', () => {
                const propertyId = icon.getAttribute("data-property-id");
                const card = document.getElementById(`card_${propertyId}`);
                card.style.display = "none";

                const xhr = new XMLHttpRequest();
                xhr.open("POST", "./seller_db.php");
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        location.reload();
                    } else {
                        alert("Error deleting the property.");
                    }
                };
                xhr.send(`action=delete&property_id=${propertyId}`);
            });
        });


    </script>

</body>

</html>