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

$message = "";


// =========================
// UPDATE FOOD ITEM
// =========================
if (isset($_POST['update_food'])) {

    $food_id = $_POST['food_id'];
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

        $update_query = "UPDATE fooditems
                         SET food_name = '$food_name',
                             food_description = '$food_description',
                             food_tag = '$food_tag',
                             price = '$price',
                             is_available = '$is_available',
                             calories = $calories
                         WHERE food_id = '$food_id'
                         AND restaurant_id = '$restaurant_id'";

        mysqli_query($conn, $update_query);

        $message = "Food item updated successfully.";

    } else {

        $message = "Price must be greater than 0.";
    }
}


// =========================
// GET RESTAURANT FOOD ITEMS
// =========================
$query = "SELECT *
          FROM fooditems
          WHERE restaurant_id = '$restaurant_id'
          ORDER BY food_id";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Restaurant Menu</title>
</head>

<body>

    <h1>Restaurant Menu</h1>

    <?php
    if ($message != "") {
        echo "<p>$message</p>";
    }
    ?>

    <a href="add_food.php">Add New Food Item</a>

    <br><br>

    <?php if (mysqli_num_rows($result) > 0) { ?>

        <?php while ($food = mysqli_fetch_assoc($result)) { ?>

            <form action="restaurant_menu.php" method="POST">

                <input type="hidden"
                       name="food_id"
                       value="<?php echo $food['food_id']; ?>">


                <label for="food_name_<?php echo $food['food_id']; ?>">
                    Food Name:
                </label>

                <input type="text"
                       id="food_name_<?php echo $food['food_id']; ?>"
                       name="food_name"
                       value="<?php echo $food['food_name']; ?>"
                       required>

                <br><br>


                <label for="food_description_<?php echo $food['food_id']; ?>">
                    Description:
                </label>

                <textarea
                    id="food_description_<?php echo $food['food_id']; ?>"
                    name="food_description"><?php echo $food['food_description']; ?></textarea>

                <br><br>


                <label for="food_tag_<?php echo $food['food_id']; ?>">
                    Food Tag:
                </label>

                <select
                    id="food_tag_<?php echo $food['food_id']; ?>"
                    name="food_tag"
                    required>

                    <option value="Deshi"
                        <?php if ($food['food_tag'] == 'Deshi') echo 'selected'; ?>>
                        Deshi
                    </option>

                    <option value="Indian"
                        <?php if ($food['food_tag'] == 'Indian') echo 'selected'; ?>>
                        Indian
                    </option>

                    <option value="Chinese"
                        <?php if ($food['food_tag'] == 'Chinese') echo 'selected'; ?>>
                        Chinese
                    </option>

                    <option value="Vegan"
                        <?php if ($food['food_tag'] == 'Vegan') echo 'selected'; ?>>
                        Vegan
                    </option>

                    <option value="Non-Vegan"
                        <?php if ($food['food_tag'] == 'Non-Vegan') echo 'selected'; ?>>
                        Non-Vegan
                    </option>

                    <option value="Halal"
                        <?php if ($food['food_tag'] == 'Halal') echo 'selected'; ?>>
                        Halal
                    </option>

                    <option value="Fast Food"
                        <?php if ($food['food_tag'] == 'Fast Food') echo 'selected'; ?>>
                        Fast Food
                    </option>

                    <option value="Extra Protein"
                        <?php if ($food['food_tag'] == 'Extra Protein') echo 'selected'; ?>>
                        Extra Protein
                    </option>

                </select>

                <br><br>


                <label for="price_<?php echo $food['food_id']; ?>">
                    Price:
                </label>

                <input type="number"
                       id="price_<?php echo $food['food_id']; ?>"
                       name="price"
                       value="<?php echo $food['price']; ?>"
                       min="0.01"
                       step="0.01"
                       required>

                <br><br>


                <label for="calories_<?php echo $food['food_id']; ?>">
                    Calories:
                </label>

                <input type="number"
                       id="calories_<?php echo $food['food_id']; ?>"
                       name="calories"
                       value="<?php echo $food['calories']; ?>"
                       min="0">

                <br><br>


                <label for="is_available_<?php echo $food['food_id']; ?>">
                    Availability:
                </label>

                <select
                    id="is_available_<?php echo $food['food_id']; ?>"
                    name="is_available"
                    required>

                    <option value="1"
                        <?php if ($food['is_available'] == 1) echo 'selected'; ?>>
                        Available
                    </option>

                    <option value="0"
                        <?php if ($food['is_available'] == 0) echo 'selected'; ?>>
                        Unavailable
                    </option>

                </select>

                <br><br>


                <button type="submit" name="update_food">
                    Save Changes
                </button>

            </form>

            <hr>

        <?php } ?>

    <?php } else { ?>

        <p>No food items have been added yet.</p>

    <?php } ?>

    <br>

    <a href="restaurant_dashboard.php">Back to Dashboard</a>

</body>

</html>