<?php

session_start();
require_once('DBconnect.php');

# costomer login check
if (!isset($_SESSION['login_id']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'user') {

    header("Location: index.php");
    exit;
}

$login_id = $_SESSION['login_id'];

# fetch customer info
$customer_query = "SELECT *
                   FROM customers
                   WHERE login_id = '$login_id'";

$customer_result = mysqli_query($conn, $customer_query);
$customer = mysqli_fetch_assoc($customer_result);

$foodPreference = $customer['foodPreference'];

# get cuisine filter
$selectedCuisine = "";

if (isset($_GET['cuisine'])) {
    $selectedCuisine = $_GET['cuisine'];
}

# get restaurants with average ratings and filter by cuisine if selected
if ($selectedCuisine != "") {

    $restaurant_query = "SELECT
                                r.*,
                                AVG(rv.rating) AS average_rating,
                                COUNT(rv.rating) AS rating_count

                         FROM restaurants r

                         LEFT JOIN reviews rv
                         ON r.login_id = rv.restaurant_id
                         AND rv.rating IS NOT NULL

                         WHERE r.cuisineType = '$selectedCuisine'

                         GROUP BY r.login_id

                         ORDER BY r.restaurant_name";

} else {

    $restaurant_query = "SELECT
                                r.*,
                                AVG(rv.rating) AS average_rating,
                                COUNT(rv.rating) AS rating_count

                         FROM restaurants r

                         LEFT JOIN reviews rv
                         ON r.login_id = rv.restaurant_id
                         AND rv.rating IS NOT NULL

                         GROUP BY r.login_id

                         ORDER BY
                         CASE
                             WHEN r.cuisineType = '$foodPreference' THEN 0
                             ELSE 1
                         END,
                         r.restaurant_name";
}

$restaurant_result = mysqli_query($conn, $restaurant_query);

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Panda Foods - Browse Restaurants</title>

    <link rel="stylesheet" href="style.css?v=4">

</head>


<body class="browse-restaurants-page">


    <main class="browse-restaurants-shell">


        <!-- =========================
             PARTICLES
             ========================= -->

        <div class="dashboard-particles"
             aria-hidden="true">

            <span class="particle-line line1"></span>
            <span class="particle-line line2"></span>
            <span class="particle-line line3"></span>
            <span class="particle-line line4"></span>
            <span class="particle-line line5"></span>
            <span class="particle-line line6"></span>

            <span class="particle circle p1"></span>
            <span class="particle circle p2"></span>
            <span class="particle circle p3"></span>
            <span class="particle circle p4"></span>
            <span class="particle circle p5"></span>

            <span class="particle circle-outline p6"></span>
            <span class="particle circle-outline p7"></span>
            <span class="particle circle-outline p8"></span>
            <span class="particle circle-outline p9"></span>

            <span class="particle square p10"></span>
            <span class="particle square p11"></span>
            <span class="particle square p12"></span>
            <span class="particle square p13"></span>

            <span class="particle triangle p14"></span>
            <span class="particle triangle p15"></span>
            <span class="particle triangle p16"></span>
            <span class="particle triangle p17"></span>

            <span class="particle dot p18"></span>
            <span class="particle dot p19"></span>
            <span class="particle dot p20"></span>
            <span class="particle dot p21"></span>
            <span class="particle dot p22"></span>
            <span class="particle dot p23"></span>

            <span class="particle diamond p24"></span>
            <span class="particle diamond p25"></span>
            <span class="particle diamond p26"></span>

        </div>


        <!-- =========================
             PAGE CONTENT
             ========================= -->

        <div class="browse-restaurants-content">


            <!-- =========================
                 TOP HEADER
                 ========================= -->

            <section class="browse-restaurants-header">

                <div>

                    <p class="browse-page-label">
                        Panda Foods
                    </p>

                    <h1>Browse Restaurants</h1>

                    <p class="browse-page-description">

                        Find restaurants that match your taste
                        and explore what they have to offer.

                    </p>

                </div>


                <a href="user_dashboard.php"
                   class="browse-back-button">

                    ← Back to Dashboard

                </a>

            </section>



            <!-- =========================
                 FILTER BAR
                 ========================= -->

            <section class="browse-filter-card">


                <div class="browse-preference">

                    <span>Your food preference</span>

                    <strong>
                        <?php echo htmlspecialchars($foodPreference); ?>
                    </strong>

                </div>


                <form action="browse_restaurants.php"
                      method="GET"
                      class="browse-filter-form">


                    <div class="browse-filter-field">

                        <label for="cuisine">
                            Filter by Cuisine
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

                    </div>


                    <button type="submit"
                            class="browse-filter-button">

                        Apply Filter

                    </button>

                </form>


            </section>



            <!-- =========================
                 RESTAURANT LIST
                 ========================= -->

            <section class="restaurant-list-section">


                <div class="restaurant-list-heading">

                    <div>

                        <p class="browse-page-label">
                            RESTAURANTS
                        </p>

                        <h2>
                            <?php
                            if ($selectedCuisine != "") {
                                echo htmlspecialchars($selectedCuisine) . " Restaurants";
                            } else {
                                echo "Restaurants for You";
                            }
                            ?>
                        </h2>

                    </div>


                    <span class="restaurant-count">

                        <?php
                        echo mysqli_num_rows($restaurant_result);
                        ?>
                        found

                    </span>

                </div>



                <div class="restaurant-scroll-area">


                    <?php if (mysqli_num_rows($restaurant_result) > 0) { ?>


                        <?php while ($restaurant = mysqli_fetch_assoc($restaurant_result)) { ?>


                            <article class="restaurant-card">


                                <div class="restaurant-card-main">

                                    <div class="restaurant-card-top">

                                        <div>

                                            <p class="restaurant-cuisine">
                                                <?php
                                                echo htmlspecialchars(
                                                    $restaurant['cuisineType']
                                                );
                                                ?>
                                            </p>


                                            <!-- =========================
                                                 NAME + RATING
                                                 ========================= -->

                                            <div class="restaurant-name-rating">


                                                <h3>
                                                    <?php
                                                    echo htmlspecialchars(
                                                        $restaurant['restaurant_name']
                                                    );
                                                    ?>
                                                </h3>



                                                <div class="restaurant-rating-preview">


                                                    <?php
                                                    if ($restaurant['rating_count'] > 0) {
                                                    ?>


                                                        <span class="restaurant-rating-star">
                                                            ★
                                                        </span>


                                                        <strong>
                                                            <?php
                                                            echo number_format(
                                                                $restaurant['average_rating'],
                                                                1
                                                            );
                                                            ?>
                                                        </strong>


                                                        <span class="restaurant-rating-count">

                                                            (<?php
                                                            echo $restaurant['rating_count'];
                                                            ?>)

                                                        </span>


                                                    <?php } else { ?>


                                                        <span class="restaurant-rating-star empty">
                                                            ☆
                                                        </span>


                                                        <span class="restaurant-rating-new">
                                                            New
                                                        </span>


                                                    <?php } ?>


                                                </div>


                                            </div>


                                        </div>



                                        <?php
                                        if ($selectedCuisine == "" &&
                                            $restaurant['cuisineType'] == $foodPreference) {
                                        ?>

                                            <span class="restaurant-match-badge">
                                                Matches your preference
                                            </span>

                                        <?php } ?>


                                    </div>



                                    <div class="restaurant-location">

                                        <span>Location</span>

                                        <strong>

                                            <?php
                                            echo htmlspecialchars(
                                                $restaurant['street']
                                            );
                                            ?>,

                                            <?php
                                            echo htmlspecialchars(
                                                $restaurant['area']
                                            );
                                            ?>,

                                            <?php
                                            echo htmlspecialchars(
                                                $restaurant['city']
                                            );
                                            ?>

                                        </strong>

                                    </div>

                                </div>



                                <a href="browse_menu.php?restaurant_id=<?php
                                   echo $restaurant['login_id'];
                                   ?>"
                                   class="restaurant-menu-button">

                                    View Menu
                                    <span>→</span>

                                </a>


                            </article>


                        <?php } ?>


                    <?php } else { ?>


                        <div class="restaurant-empty-state">

                            <h3>No restaurants found</h3>

                            <p>
                                There are currently no restaurants
                                available for this cuisine.
                            </p>

                            <a href="browse_restaurants.php">
                                Show All Restaurants
                            </a>

                        </div>


                    <?php } ?>


                </div>


            </section>


        </div>


    </main>


</body>

</html>