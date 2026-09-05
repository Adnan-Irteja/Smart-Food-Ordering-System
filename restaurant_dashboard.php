<?php

session_start();
require_once('DBconnect.php');

# sign out
if (isset($_GET['logout'])) {

    session_unset();
    session_destroy();

    header("Location: index.php");
    exit;
}

# restaurant login check
if (!isset($_SESSION['login_id']) ||
    $_SESSION['role'] != 'restaurant_owner') {

    header("Location: index.php");
    exit;
}

$login_id = $_SESSION['login_id'];

# get restaurant info
$query = "SELECT * FROM restaurants
          WHERE login_id = '$login_id'";

$result = mysqli_query($conn, $query);

$restaurant = mysqli_fetch_assoc($result);

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Panda Foods - Restaurant Dashboard</title>

    <link rel="stylesheet" href="style.css?v=2">

</head>


<body class="restaurant-dashboard-page">


    <main class="restaurant-dashboard-shell">


        <!-- =========================
             FLOATING PARTICLES
             ========================= -->

        <div class="restaurant-dashboard-particles"
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



        <!-- =========================
             DASHBOARD CONTENT
             ========================= -->

        <div class="restaurant-dashboard-content">


            <!-- =========================
                 LEFT SIDE
                 ========================= -->

            <section class="restaurant-dashboard-left">


                <!-- WELCOME -->

                <div class="restaurant-welcome">

                    <p class="restaurant-welcome-small">
                        Restaurant Dashboard
                    </p>

                    <h1>
                        Welcome to
                        <?php
                        echo htmlspecialchars(
                            $restaurant['restaurant_name']
                        );
                        ?>!
                    </h1>

                    <p>
                        Manage your restaurant from one place.
                    </p>

                </div>



                <!-- RESTAURANT PROFILE -->

                <div class="restaurant-info-card">

                    <div class="restaurant-card-heading">

                        <p class="restaurant-card-label">
                            RESTAURANT
                        </p>

                        <h2>Restaurant Profile</h2>

                    </div>


                    <div class="restaurant-info-row">

                        <span>Restaurant Name</span>

                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $restaurant['restaurant_name']
                            );
                            ?>
                        </strong>

                    </div>


                    <div class="restaurant-info-row">

                        <span>Username</span>

                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $restaurant['username']
                            );
                            ?>
                        </strong>

                    </div>


                    <div class="restaurant-info-row">

                        <span>Cuisine Type</span>

                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $restaurant['cuisineType']
                            );
                            ?>
                        </strong>

                    </div>

                </div>



                <!-- ADDRESS -->

                <div class="restaurant-info-card">

                    <div class="restaurant-card-heading">

                        <p class="restaurant-card-label">
                            LOCATION
                        </p>

                        <h2>Restaurant Address</h2>

                    </div>


                    <div class="restaurant-info-row">

                        <span>City</span>

                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $restaurant['city']
                            );
                            ?>
                        </strong>

                    </div>


                    <div class="restaurant-info-row">

                        <span>Street</span>

                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $restaurant['street']
                            );
                            ?>
                        </strong>

                    </div>


                    <div class="restaurant-info-row">

                        <span>Area</span>

                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $restaurant['area']
                            );
                            ?>
                        </strong>

                    </div>

                </div>


            </section>



            <!-- =========================
                 RIGHT SIDE
                 ========================= -->

            <section class="restaurant-dashboard-right">


                <!-- BRANDING -->

                <div class="restaurant-dashboard-branding">

                    <p class="restaurant-brand-label">
                        Panda Foods
                    </p>

                    <h2>
                        Manage your<br>
                        restaurant.
                    </h2>

                    <p>
                        Update your menu, manage coupons,
                        handle orders and keep up with customer feedback.
                    </p>

                </div>



                <!-- =========================
                     ACTION GRID
                     ========================= -->

                <nav class="restaurant-actions">


                    <a class="restaurant-action"
                       href="add_food.php">

                        <strong>Add Food</strong>

                        <span>
                            Create a new menu item
                        </span>

                        <span class="restaurant-action-arrow">
                            →
                        </span>

                    </a>



                    <a class="restaurant-action"
                       href="restaurant_menu.php">

                        <strong>Restaurant Menu</strong>

                        <span>
                            View and edit food items
                        </span>

                        <span class="restaurant-action-arrow">
                            →
                        </span>

                    </a>



                    <a class="restaurant-action"
                       href="res_coupons.php">

                        <strong>Add Coupon</strong>

                        <span>
                            Create a new discount
                        </span>

                        <span class="restaurant-action-arrow">
                            →
                        </span>

                    </a>



                    <a class="restaurant-action"
                       href="view_res_coupons.php">

                        <strong>View Coupons</strong>

                        <span>
                            See your active coupons
                        </span>

                        <span class="restaurant-action-arrow">
                            →
                        </span>

                    </a>



                    <a class="restaurant-action"
                       href="restaurant_orders.php">

                        <strong>Restaurant Orders</strong>

                        <span>
                            Manage active customer orders
                        </span>

                        <span class="restaurant-action-arrow">
                            →
                        </span>

                    </a>



                    <a class="restaurant-action"
                       href="restaurant_reviews.php">

                        <strong>Customer Reviews</strong>

                        <span>
                            View ratings and feedback
                        </span>

                        <span class="restaurant-action-arrow">
                            →
                        </span>

                    </a>



                    <a class="restaurant-action restaurant-signout"
                       href="restaurant_dashboard.php?logout=1">

                        <strong>Sign Out</strong>

                        <span>
                            Return to the login page
                        </span>

                        <span class="restaurant-action-arrow">
                            →
                        </span>

                    </a>


                </nav>


            </section>


        </div>


    </main>


</body>

</html>