<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Seller Dashboard</title>
</head>

<body>
    <?php
    session_start();
    $username = $_SESSION['first_name'];
    echo "<h1>Welcome, {$username}!</h1>";
    echo "<div>Seller Dashboard</div>";
    ?>
</body>

</html>