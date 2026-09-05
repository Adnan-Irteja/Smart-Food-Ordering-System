<?php

session_start();
require_once('DBconnect.php');


// =========================
// CHECK CUSTOMER LOGIN
// =========================

if (!isset($_SESSION['login_id']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'user') {

    header("Location: index.php");
    exit;
}


// =========================
// GET RESTAURANT ID
// =========================

if (!isset($_GET['restaurant_id'])) {
    header("Location: browse_restaurants.php");
    exit;
}

$restaurant_id = $_GET['restaurant_id'];


// =========================
// GET RESTAURANT INFORMATION
// =========================

$restaurant_query = "SELECT *
                     FROM restaurants
                     WHERE login_id = '$restaurant_id'";

$restaurant_result = mysqli_query($conn, $restaurant_query);

if (mysqli_num_rows($restaurant_result) == 0) {
    header("Location: browse_restaurants.php");
    exit;
}

$restaurant = mysqli_fetch_assoc($restaurant_result);


// =========================
// MESSAGE
// =========================

$message = "";


// =========================
// ADD FOOD TO CART
// =========================

if (isset($_POST['add_to_cart'])) {

    $food_id = $_POST['food_id'];
    $quantity = $_POST['quantity'];


    // Make sure quantity is valid
    if ($quantity < 1) {
        $quantity = 1;
    }


    // Make sure the selected food belongs to this restaurant
    // and is currently available
    $food_query = "SELECT *
                   FROM fooditems
                   WHERE food_id = '$food_id'
                   AND restaurant_id = '$restaurant_id'
                   AND is_available = 1";

    $food_result = mysqli_query($conn, $food_query);


    if (mysqli_num_rows($food_result) > 0) {

        $food = mysqli_fetch_assoc($food_result);


        // If cart does not exist yet, create it
        if (!isset($_SESSION['cart'])) {

            $_SESSION['cart'] = array();
            $_SESSION['cart_restaurant_id'] = $restaurant_id;
        }


        // Do not allow food from multiple restaurants
        if ($_SESSION['cart_restaurant_id'] != $restaurant_id) {

            $message = "Your cart already contains food from another restaurant.";

        } else {

            // If food is already in cart, increase quantity
            if (isset($_SESSION['cart'][$food_id])) {

                $_SESSION['cart'][$food_id]['quantity'] += $quantity;

            } else {

                // Otherwise add it as a new cart item
                $_SESSION['cart'][$food_id] = array(
                    'food_id' => $food['food_id'],
                    'food_name' => $food['food_name'],
                    'price' => $food['price'],
                    'quantity' => $quantity
                );
            }

            $message = $food['food_name'] . " added to cart.";
        }

    } else {

        $message = "This food item is currently unavailable.";
    }
}


// =========================
// GET FOOD FILTER
// =========================

$selectedTag = "";

if (isset($_GET['food_tag'])) {
    $selectedTag = $_GET['food_tag'];
}


// =========================
// GET FOOD ITEMS
// =========================

if ($selectedTag != "") {

    $food_query = "SELECT *
                   FROM fooditems
                   WHERE restaurant_id = '$restaurant_id'
                   AND is_available = 1
                   AND food_tag = '$selectedTag'
                   ORDER BY food_name";

} else {

    $food_query = "SELECT *
                   FROM fooditems
                   WHERE restaurant_id = '$restaurant_id'
                   AND is_available = 1
                   ORDER BY food_name";
}

$food_result = mysqli_query($conn, $food_query);

?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo $restaurant['restaurant_name']; ?> Menu</title>
</head>

<body>


    <!-- =========================
         RESTAURANT INFORMATION
         ========================= -->

    <h1>
        <?php echo $restaurant['restaurant_name']; ?>
    </h1>

    <p>
        <strong>Cuisine:</strong>
        <?php echo $restaurant['cuisineType']; ?>
    </p>

    <p>
        <strong>Location:</strong>
        <?php echo $restaurant['street']; ?>,
        <?php echo $restaurant['area']; ?>,
        <?php echo $restaurant['city']; ?>
    </p>


    <?php
    if ($message != "") {
        echo "<p><strong>$message</strong></p>";
    }
    ?>


    <!-- =========================
         FOOD TYPE FILTER
         ========================= -->

    <h2>Menu</h2>

    <form action="browse_menu.php" method="GET">

        <input type="hidden"
               name="restaurant_id"
               value="<?php echo $restaurant_id; ?>">


        <label for="food_tag">
            Filter by Food Type:
        </label>

        <select id="food_tag"
                name="food_tag">

            <option value=""
                <?php if ($selectedTag == "") echo "selected"; ?>>
                All Food Types
            </option>

            <option value="Deshi"
                <?php if ($selectedTag == "Deshi") echo "selected"; ?>>
                Deshi
            </option>

            <option value="Indian"
                <?php if ($selectedTag == "Indian") echo "selected"; ?>>
                Indian
            </option>

            <option value="Chinese"
                <?php if ($selectedTag == "Chinese") echo "selected"; ?>>
                Chinese
            </option>

            <option value="Vegan"
                <?php if ($selectedTag == "Vegan") echo "selected"; ?>>
                Vegan
            </option>

            <option value="Non-Vegan"
                <?php if ($selectedTag == "Non-Vegan") echo "selected"; ?>>
                Non-Vegan
            </option>

            <option value="Halal"
                <?php if ($selectedTag == "Halal") echo "selected"; ?>>
                Halal
            </option>

            <option value="Fast Food"
                <?php if ($selectedTag == "Fast Food") echo "selected"; ?>>
                Fast Food
            </option>

            <option value="Extra Protein"
                <?php if ($selectedTag == "Extra Protein") echo "selected"; ?>>
                Extra Protein
            </option>

        </select>

        <button type="submit">
            Apply Filter
        </button>

    </form>


    <br><br>


    <!-- =========================
         FOOD ITEMS
         ========================= -->

    <?php if (mysqli_num_rows($food_result) > 0) { ?>


        <?php while ($food = mysqli_fetch_assoc($food_result)) { ?>

            <div>

                <h3>
                    <?php echo $food['food_name']; ?>
                </h3>


                <?php if ($food['food_description'] != "") { ?>

                    <p>
                        <?php echo $food['food_description']; ?>
                    </p>

                <?php } ?>


                <p>
                    <strong>Food Type:</strong>
                    <?php echo $food['food_tag']; ?>
                </p>


                <p>
                    <strong>Price:</strong>
                    Tk. <?php echo $food['price']; ?>
                </p>


                <?php if ($food['calories'] != NULL) { ?>

                    <p>
                        <strong>Calories:</strong>
                        <?php echo $food['calories']; ?> kcal
                    </p>

                <?php } ?>


                <!-- ADD TO CART -->

                <form action="browse_menu.php?restaurant_id=<?php echo $restaurant_id; ?>"
                      method="POST">

                    <input type="hidden"
                           name="food_id"
                           value="<?php echo $food['food_id']; ?>">


                    <label for="quantity_<?php echo $food['food_id']; ?>">
                        Quantity:
                    </label>

                    <input type="number"
                           id="quantity_<?php echo $food['food_id']; ?>"
                           name="quantity"
                           value="1"
                           min="1"
                           required>


                    <button type="submit"
                            name="add_to_cart">

                        Add to Cart

                    </button>

                </form>


                <hr>

            </div>

        <?php } ?>


    <?php } else { ?>

        <p>No available food items found.</p>

    <?php } ?>


    <br>


    <!-- =========================
         NAVIGATION
         ========================= -->

    <a href="browse_restaurants.php">
        Back to Restaurants
    </a>


    <?php if (isset($_SESSION['cart']) &&
              count($_SESSION['cart']) > 0) { ?>

        <br><br>

        <a href="cart.php">
            View Cart
        </a>

    <?php } ?>


</body>

</html>