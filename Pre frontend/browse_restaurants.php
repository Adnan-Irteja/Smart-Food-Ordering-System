<?php

session_start();
require_once('DBconnect.php');

// Make sure the user is logged in and is actually a customer
if (!isset($_SESSION['login_id']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'user') {

    header("Location: index.php");
    exit;
}

$login_id = $_SESSION['login_id'];


// =========================
// GET CUSTOMER INFORMATION
// =========================

$customer_query = "SELECT *
                   FROM customers
                   WHERE login_id = '$login_id'";

$customer_result = mysqli_query($conn, $customer_query);
$customer = mysqli_fetch_assoc($customer_result);

$foodPreference = $customer['foodPreference'];


// =========================
// GET SELECTED CUISINE FILTER
// =========================

$selectedCuisine = "";

if (isset($_GET['cuisine'])) {
    $selectedCuisine = $_GET['cuisine'];
}


// =========================
// GET RESTAURANTS
// =========================

if ($selectedCuisine != "") {

    // If a cuisine was selected, show only restaurants
    // belonging to that cuisine
    $restaurant_query = "SELECT *
                         FROM restaurants
                         WHERE cuisineType = '$selectedCuisine'
                         ORDER BY restaurant_name";

} else {

    // Otherwise show all restaurants,
    // but place restaurants matching the user's
    // food preference first
    $restaurant_query = "SELECT *
                         FROM restaurants
                         ORDER BY
                         CASE
                             WHEN cuisineType = '$foodPreference' THEN 0
                             ELSE 1
                         END,
                         restaurant_name";
}

$restaurant_result = mysqli_query($conn, $restaurant_query);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Browse Restaurants</title>
</head>

<body>

    <h1>Browse Restaurants</h1>

    <p>
        Your food preference:
        <strong><?php echo $foodPreference; ?></strong>
    </p>


    <!-- =========================
         CUISINE FILTER
         ========================= -->

    <form action="browse_restaurants.php" method="GET">

        <label for="cuisine">
            Filter by Cuisine:
        </label>

        <select id="cuisine"
                name="cuisine">

            <option value=""
                <?php if ($selectedCuisine == "") echo "selected"; ?>>
                All Cuisines
            </option>

            <option value="Deshi"
                <?php if ($selectedCuisine == "Deshi") echo "selected"; ?>>
                Deshi
            </option>

            <option value="Indian"
                <?php if ($selectedCuisine == "Indian") echo "selected"; ?>>
                Indian
            </option>

            <option value="Chinese"
                <?php if ($selectedCuisine == "Chinese") echo "selected"; ?>>
                Chinese
            </option>

            <option value="Vegan"
                <?php if ($selectedCuisine == "Vegan") echo "selected"; ?>>
                Vegan
            </option>

            <option value="Non-Vegan"
                <?php if ($selectedCuisine == "Non-Vegan") echo "selected"; ?>>
                Non-Vegan
            </option>

            <option value="Halal"
                <?php if ($selectedCuisine == "Halal") echo "selected"; ?>>
                Halal
            </option>

            <option value="Fast Food"
                <?php if ($selectedCuisine == "Fast Food") echo "selected"; ?>>
                Fast Food
            </option>

            <option value="Extra Protein"
                <?php if ($selectedCuisine == "Extra Protein") echo "selected"; ?>>
                Extra Protein
            </option>

        </select>

        <button type="submit">
            Apply Filter
        </button>

    </form>


    <br><br>


    <!-- =========================
         RESTAURANT LIST
         ========================= -->

    <?php if (mysqli_num_rows($restaurant_result) > 0) { ?>

        <?php while ($restaurant = mysqli_fetch_assoc($restaurant_result)) { ?>

            <div>

                <h2>
                    <?php echo $restaurant['restaurant_name']; ?>
                </h2>

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

                <a href="browse_menu.php?restaurant_id=<?php echo $restaurant['login_id']; ?>">
                    View Menu
                </a>

                <hr>

            </div>

        <?php } ?>

    <?php } else { ?>

        <p>No restaurants found for this cuisine.</p>

    <?php } ?>


    <br>

    <a href="user_dashboard.php">
        Back to Dashboard
    </a>

</body>

</html>