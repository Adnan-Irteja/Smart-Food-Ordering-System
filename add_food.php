<?php

session_start();
require_once('DBconnect.php');

# restaurant login check
if (!isset($_SESSION['login_id']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'restaurant_owner') {

    header("Location: index.php");
    exit;
}

$restaurant_id = $_SESSION['login_id'];


# fetch restaurant info
$restaurant_query = "SELECT * FROM restaurants
                     WHERE login_id = '$restaurant_id'";

$restaurant_result = mysqli_query($conn, $restaurant_query);
$restaurant = mysqli_fetch_assoc($restaurant_result);
$cuisineType = $restaurant['cuisineType'];

$message = "";


# adding new food item
if (isset($_POST['food_name']) &&
    isset($_POST['food_tag']) &&
    isset($_POST['price']) &&
    isset($_POST['is_available'])) {

    $food_name = $_POST['food_name'];

    $food_description =
        $_POST['food_description'];

    $food_tag = $_POST['food_tag'];

    $price = $_POST['price'];

    $is_available =
        $_POST['is_available'];


    // Calories is optional

    if ($_POST['calories'] == "") {
        $calories = "NULL";

    } else {
        $calories = $_POST['calories'];
    }


    if ($price > 0) {

        $query = "INSERT INTO fooditems
                  (
                      food_name,
                      food_description,
                      food_tag,
                      price,
                      is_available,
                      calories,
                      restaurant_id
                  )
                  VALUES
                  (
                      '$food_name',
                      '$food_description',
                      '$food_tag',
                      '$price',
                      '$is_available',
                      $calories,
                      '$restaurant_id'
                  )";


        mysqli_query($conn, $query);


        header("Location: restaurant_menu.php");
        exit;

    } else {

        $message =
            "Price must be greater than 0.";
    }
}

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Panda Foods - Add Food</title>

    <link rel="stylesheet"
          href="style.css?v=3">

</head>


<body class="restaurant-add-food-page">


    <main class="restaurant-add-food-shell">


        <!-- =========================
             PARTICLES
             ========================= -->

        <!-- =========================
     FLOATING PARTICLES
     ========================= -->

<div class="restaurant-add-food-particles"
     aria-hidden="true">


    <!-- LINES -->

    <span class="particle-line line1"></span>
    <span class="particle-line line2"></span>
    <span class="particle-line line3"></span>
    <span class="particle-line line4"></span>
    <span class="particle-line line5"></span>
    <span class="particle-line line6"></span>


    <!-- CIRCLES -->

    <span class="particle circle p1"></span>
    <span class="particle circle p2"></span>
    <span class="particle circle p3"></span>
    <span class="particle circle p4"></span>
    <span class="particle circle p5"></span>


    <!-- OUTLINED CIRCLES -->

    <span class="particle circle-outline p6"></span>
    <span class="particle circle-outline p7"></span>
    <span class="particle circle-outline p8"></span>
    <span class="particle circle-outline p9"></span>


    <!-- SQUARES -->

    <span class="particle square p10"></span>
    <span class="particle square p11"></span>
    <span class="particle square p12"></span>
    <span class="particle square p13"></span>


    <!-- TRIANGLES -->

    <span class="particle triangle p14"></span>
    <span class="particle triangle p15"></span>
    <span class="particle triangle p16"></span>
    <span class="particle triangle p17"></span>


    <!-- DOTS -->

    <span class="particle dot p18"></span>
    <span class="particle dot p19"></span>
    <span class="particle dot p20"></span>
    <span class="particle dot p21"></span>
    <span class="particle dot p22"></span>
    <span class="particle dot p23"></span>


    <!-- DIAMONDS -->

    <span class="particle diamond p24"></span>
    <span class="particle diamond p25"></span>
    <span class="particle diamond p26"></span>


</div>



        <div class="restaurant-add-food-content">


            <!-- =========================
                 HEADER
                 ========================= -->

            <section class="restaurant-management-header">


                <div>

                    <p class="restaurant-management-label">
                        PANDA FOODS
                    </p>


                    <h1>
                        Add Food Item
                    </h1>


                    <p>

                        Add a new dish to

                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $restaurant['restaurant_name']
                            );
                            ?>
                        </strong>.

                    </p>

                </div>


                <a href="restaurant_dashboard.php"
                   class="restaurant-management-back">

                    ← Back to Dashboard

                </a>


            </section>



            <!-- =========================
                 FORM CARD
                 ========================= -->

            <section class="restaurant-add-food-card">


                <div class="restaurant-add-food-card-top">


                    <p class="restaurant-card-label">
                        MENU MANAGEMENT
                    </p>


                    <h2>
                        New Menu Item
                    </h2>


                    <p>
                        Enter the food details below.
                    </p>


                </div>



                <?php if ($message != "") { ?>


                    <div class="restaurant-form-message">

                        <?php
                        echo htmlspecialchars($message);
                        ?>

                    </div>


                <?php } ?>



                <form action="add_food.php"
                      method="POST"
                      class="restaurant-food-form">


                    <!-- =========================
                         FOOD NAME
                         ========================= -->

                    <div class="restaurant-form-group restaurant-form-full">


                        <label for="food_name">
                            Food Name
                        </label>


                        <input
                            type="text"
                            id="food_name"
                            name="food_name"
                            placeholder="e.g. Chicken Biryani"
                            required
                        >


                    </div>



                    <!-- =========================
                         DESCRIPTION
                         ========================= -->

                    <div class="restaurant-form-group restaurant-form-full">


                        <label for="food_description">
                            Description
                        </label>


                        <textarea
                            id="food_description"
                            name="food_description"
                            placeholder="Briefly describe the food item..."
                        ></textarea>


                    </div>



                    <!-- =========================
                         TAG
                         ========================= -->

                    <div class="restaurant-form-group">


                        <label for="food_tag">
                            Food Tag
                        </label>


                        <select
                            id="food_tag"
                            name="food_tag"
                            required
                        >


                            <option value="Deshi"
                                <?php
                                if ($cuisineType == 'Deshi')
                                    echo 'selected';
                                ?>>

                                Deshi

                            </option>


                            <option value="Indian"
                                <?php
                                if ($cuisineType == 'Indian')
                                    echo 'selected';
                                ?>>

                                Indian

                            </option>


                            <option value="Chinese"
                                <?php
                                if ($cuisineType == 'Chinese')
                                    echo 'selected';
                                ?>>

                                Chinese

                            </option>


                            <option value="Vegan"
                                <?php
                                if ($cuisineType == 'Vegan')
                                    echo 'selected';
                                ?>>

                                Vegan

                            </option>


                            <option value="Non-Vegan"
                                <?php
                                if ($cuisineType == 'Non-Vegan')
                                    echo 'selected';
                                ?>>

                                Non-Vegan

                            </option>


                            <option value="Halal"
                                <?php
                                if ($cuisineType == 'Halal')
                                    echo 'selected';
                                ?>>

                                Halal

                            </option>


                            <option value="Fast Food"
                                <?php
                                if ($cuisineType == 'Fast Food')
                                    echo 'selected';
                                ?>>

                                Fast Food

                            </option>


                            <option value="Extra Protein"
                                <?php
                                if ($cuisineType == 'Extra Protein')
                                    echo 'selected';
                                ?>>

                                Extra Protein

                            </option>

                            <option value="Drinks"
                                <?php
                                if ($cuisineType == 'Drinks')
                                    echo 'selected';
                                ?>>

                                Drinks

                            </option>


                        </select>


                    </div>



                    <!-- =========================
                         PRICE
                         ========================= -->

                    <div class="restaurant-form-group">


                        <label for="price">
                            Price
                        </label>


                        <div class="restaurant-input-prefix">

                            <span>Tk.</span>

                            <input
                                type="number"
                                id="price"
                                name="price"
                                min="0.01"
                                step="0.01"
                                placeholder="0.00"
                                required
                            >

                        </div>


                    </div>



                    <!-- =========================
                         CALORIES
                         ========================= -->

                    <div class="restaurant-form-group">


                        <label for="calories">

                            Calories

                            <span class="restaurant-optional-text">
                                Optional
                            </span>

                        </label>


                        <input
                            type="number"
                            id="calories"
                            name="calories"
                            min="0"
                            placeholder="e.g. 450"
                        >


                    </div>



                    <!-- =========================
                         AVAILABILITY
                         ========================= -->

                    <div class="restaurant-form-group">


                        <label for="is_available">
                            Availability
                        </label>


                        <select
                            id="is_available"
                            name="is_available"
                            required
                        >

                            <option value="1">
                                Available
                            </option>

                            <option value="0">
                                Unavailable
                            </option>

                        </select>


                    </div>



                    <!-- =========================
                         BUTTONS
                         ========================= -->

                    <div class="restaurant-food-form-actions">


                        <a href="restaurant_menu.php"
                           class="restaurant-secondary-button">

                            View Menu

                        </a>


                        <button
                            type="submit"
                            class="restaurant-primary-button"
                        >

                            Add Food Item

                            <span>＋</span>

                        </button>


                    </div>


                </form>


            </section>


        </div>


    </main>


</body>

</html>