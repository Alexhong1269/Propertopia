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
        }

        .property_card {
            padding: 30px;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 30px;
            width: 200px;
            height: 300px;
        }

        h2 {
            text-align: center;
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

        form {
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            flex-direction: column;
            padding: 30px;
        }

        label {
            display: inline-block;
            width: 240px;
            text-align: right;
        }

        .input_wrapper {
            margin: 3px;
        }

        #image_file {
            margin-bottom: 30px;
        }

        #submit {
            text-align: center;
            margin: 10px auto;
        }
    </style>

    <?php
    session_start();
    $username = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
    echo "<h1>Welcome, {$username}!</h1>";
    ?>
    <div class="container">
        <h2>Seller Dashboard</h2>
        <div class="card_container">
            <div class="property_card add_new">
                <p>Register a new property</p>
                <img src="../images/add_icon.png" id="add" alt="add_icon">
            </div>
        </div>
        <div id="modal">
            <div class="modal-content">

                <form method="POST" action="">
                    <div class="input_wrapper">
                        <label for="image_file">Upload an image</label>
                        <input type="file" id="image_file" name="filename">
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
                    <input type="submit" name="submit" value="Submit" id="submit">
                </form>

            </div>
        </div>
    </div>
    <script>
        const add_icon = document.getElementById("add");
        const property_modal = document.getElementById("modal");

        add_icon.addEventListener("click", () => {
            property_modal.style.display = "block";
        })
    </script>
</body>

</html>