<?php

session_start();
require_once('DBconnect.php');

// Make sure the user is logged in and is a restaurant owner
if (!isset($_SESSION['login_id']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'restaurant_owner') {

    header("Location: index.php");
    exit;
}

$restaurant_id = $_SESSION['login_id'];


// Get the logged-in restaurant's information
$restaurant_query = "SELECT * FROM restaurants
                     WHERE login_id = '$restaurant_id'";

$restaurant_result = mysqli_query($conn, $restaurant_query);
$restaurant = mysqli_fetch_assoc($restaurant_result);

$cuisineType = $restaurant['cuisineType'];


$message = "";


// =========================
// ADD FOOD ITEM
// =========================

if (isset($_POST['food_name']) &&
    isset($_POST['food_tag']) &&
    isset($_POST['price']) &&
    isset($_POST['is_available'])) {

    $food_name = $_POST['food_name'];
    $food_description = $_POST['food_description'];
    $food_tag = $_POST['food_tag'];
    $price = $_POST['price'];
    $is_available = $_POST['is_available'];


    // Calories is optional
    if ($_POST['calories'] == "") {

        $calories = "NULL";

    } else {

        $calories = $_POST['calories'];
    }


    if ($price > 0) {

        $query = "INSERT INTO fooditems
                  (food_name,
                   food_description,
                   food_tag,
                   price,
                   is_available,
                   calories,
                   restaurant_id)
                  VALUES
                  ('$food_name',
                   '$food_description',
                   '$food_tag',
                   '$price',
                   '$is_available',
                   $calories,
                   '$restaurant_id')";

        mysqli_query($conn, $query);

        header("Location: restaurant_menu.php");
        exit;

    } else {

        $message = "Price must be greater than 0.";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Food</title>
</head>

<body>

    <h1>Add Food Item</h1>

    <?php
    if ($message != "") {
        echo "<p>$message</p>";
    }
    ?>


    <form action="add_food.php" method="POST">

        <label for="food_name">Food Name:</label>

        <input type="text"
               id="food_name"
               name="food_name"
               required>

        <br><br>


        <label for="food_description">Description:</label>

        <textarea id="food_description"
                  name="food_description"></textarea>

        <br><br>


        <label for="food_tag">Food Tag:</label>

        <select id="food_tag"
                name="food_tag"
                required>

            <option value="Deshi"
                <?php if ($cuisineType == 'Deshi') echo 'selected'; ?>>
                Deshi
            </option>

            <option value="Indian"
                <?php if ($cuisineType == 'Indian') echo 'selected'; ?>>
                Indian
            </option>

            <option value="Chinese"
                <?php if ($cuisineType == 'Chinese') echo 'selected'; ?>>
                Chinese
            </option>

            <option value="Vegan"
                <?php if ($cuisineType == 'Vegan') echo 'selected'; ?>>
                Vegan
            </option>

            <option value="Non-Vegan"
                <?php if ($cuisineType == 'Non-Vegan') echo 'selected'; ?>>
                Non-Vegan
            </option>

            <option value="Halal"
                <?php if ($cuisineType == 'Halal') echo 'selected'; ?>>
                Halal
            </option>

            <option value="Fast Food"
                <?php if ($cuisineType == 'Fast Food') echo 'selected'; ?>>
                Fast Food
            </option>

            <option value="Extra Protein"
                <?php if ($cuisineType == 'Extra Protein') echo 'selected'; ?>>
                Extra Protein
            </option>

        </select>

        <br><br>


        <label for="price">Price:</label>

        <input type="number"
               id="price"
               name="price"
               min="0.01"
               step="0.01"
               required>

        <br><br>


        <label for="calories">Calories:</label>

        <input type="number"
               id="calories"
               name="calories"
               min="0"
               placeholder="Optional">

        <br><br>


        <label for="is_available">Availability:</label>

        <select id="is_available"
                name="is_available"
                required>

            <option value="1">Available</option>
            <option value="0">Unavailable</option>

        </select>

        <br><br>


        <button type="submit">
            Add Food
        </button>

    </form>


    <br>

    <a href="restaurant_dashboard.php">
        Back to Dashboard
    </a>

</body>

</html>