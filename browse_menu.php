<?php

session_start();
require_once('DBconnect.php');

# customer login check
if (!isset($_SESSION['login_id']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'user') {

    header("Location: index.php");
    exit;
}

# fetch restaurant id
if (!isset($_GET['restaurant_id'])) {
    header("Location: browse_restaurants.php");
    exit;
}

$restaurant_id = $_GET['restaurant_id'];

# fetch restaurant info
$restaurant_query = "SELECT *
                     FROM restaurants
                     WHERE login_id = '$restaurant_id'";

$restaurant_result = mysqli_query($conn, $restaurant_query);

if (mysqli_num_rows($restaurant_result) == 0) {

    header("Location: browse_restaurants.php");
    exit;
}

$restaurant = mysqli_fetch_assoc($restaurant_result);


$message = "";


# add to cart
if (isset($_POST['add_to_cart'])) {

    $food_id = $_POST['food_id'];
    $quantity = $_POST['quantity'];


    if ($quantity < 1) {
        $quantity = 1;
    }

    $food_query = "SELECT *
                   FROM fooditems
                   WHERE food_id = '$food_id'
                   AND restaurant_id = '$restaurant_id'
                   AND is_available = 1";

    $food_result = mysqli_query($conn, $food_query);


    if (mysqli_num_rows($food_result) > 0) {

        $food = mysqli_fetch_assoc($food_result);


        if (!isset($_SESSION['cart'])) {

            $_SESSION['cart'] = array();
            $_SESSION['cart_restaurant_id'] = $restaurant_id;
        }


        if ($_SESSION['cart_restaurant_id'] != $restaurant_id) {

            $message = "Your cart already contains food from another restaurant.";

        } else {

            if (isset($_SESSION['cart'][$food_id])) {

                $_SESSION['cart'][$food_id]['quantity'] += $quantity;

            } else {

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


# get food filter
$selectedTag = "";

if (isset($_GET['food_tag'])) {
    $selectedTag = $_GET['food_tag'];
}

# get food items
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


# get restaurant rating summary
$rating_query = "SELECT AVG(rating) AS average_rating,
                        COUNT(rating) AS rating_count
                 FROM reviews
                 WHERE restaurant_id = '$restaurant_id'
                 AND rating IS NOT NULL";

$rating_result = mysqli_query($conn, $rating_query);
$rating_data = mysqli_fetch_assoc($rating_result);


# get restaurant reviews
$review_query = "SELECT rv.*,
                        c.name,
                        c.username
                 FROM reviews rv
                 JOIN customers c
                 ON rv.customer_id = c.login_id
                 WHERE rv.restaurant_id = '$restaurant_id'
                 ORDER BY rv.review_date DESC";

$review_result = mysqli_query($conn, $review_query);

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo htmlspecialchars($restaurant['restaurant_name']); ?>
        - Menu
    </title>

    <link rel="stylesheet" href="style.css?v=2">

</head>


<body class="browse-menu-page">


    <main class="browse-menu-shell">


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



        <div class="browse-menu-content">


            <!-- =========================
                 TOP HEADER
                 ========================= -->

            <section class="browse-menu-header">


                <div>

                    <p class="browse-page-label">
                        <?php
                        echo htmlspecialchars(
                            $restaurant['cuisineType']
                        );
                        ?> Restaurant
                    </p>


                    <h1>
                        <?php
                        echo htmlspecialchars(
                            $restaurant['restaurant_name']
                        );
                        ?>
                    </h1>


                    <p class="browse-menu-location">

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

                    </p>

                </div>



                <div class="browse-menu-header-actions">


                    <a href="browse_restaurants.php"
                       class="browse-back-button">

                        ← Back to Restaurants

                    </a>


                    <?php
                    if (isset($_SESSION['cart']) &&
                        count($_SESSION['cart']) > 0) {
                    ?>

                        <a href="cart.php"
                           class="browse-cart-button">

                            View Cart

                            <span>
                                <?php
                                echo count($_SESSION['cart']);
                                ?>
                            </span>

                        </a>

                    <?php } ?>


                </div>


            </section>



            <!-- =========================
                 MESSAGE
                 ========================= -->

            <?php if ($message != "") { ?>

                <div class="browse-menu-message">

                    <?php
                    echo htmlspecialchars($message);
                    ?>

                </div>

            <?php } ?>



            <!-- =========================
                 FILTER BAR
                 ========================= -->

            <section class="browse-menu-filter-card">


                <div>

                    <p class="browse-page-label">
                        MENU
                    </p>

                    <h2>Choose your food</h2>

                </div>



                <form action="browse_menu.php"
                      method="GET"
                      class="browse-filter-form">


                    <input type="hidden"
                           name="restaurant_id"
                           value="<?php
                           echo htmlspecialchars(
                               $restaurant_id
                           );
                           ?>">


                    <div class="browse-filter-field">

                        <label for="food_tag">
                            Filter by Food Type
                        </label>


                        <select id="food_tag"
                                name="food_tag">

                            <option value=""
                                <?php
                                if ($selectedTag == "")
                                    echo "selected";
                                ?>>

                                All Food Types

                            </option>


                            <option value="Deshi"
                                <?php
                                if ($selectedTag == "Deshi")
                                    echo "selected";
                                ?>>

                                Deshi

                            </option>


                            <option value="Indian"
                                <?php
                                if ($selectedTag == "Indian")
                                    echo "selected";
                                ?>>

                                Indian

                            </option>


                            <option value="Chinese"
                                <?php
                                if ($selectedTag == "Chinese")
                                    echo "selected";
                                ?>>

                                Chinese

                            </option>


                            <option value="Vegan"
                                <?php
                                if ($selectedTag == "Vegan")
                                    echo "selected";
                                ?>>

                                Vegan

                            </option>


                            <option value="Non-Vegan"
                                <?php
                                if ($selectedTag == "Non-Vegan")
                                    echo "selected";
                                ?>>

                                Non-Vegan

                            </option>


                            <option value="Halal"
                                <?php
                                if ($selectedTag == "Halal")
                                    echo "selected";
                                ?>>

                                Halal

                            </option>


                            <option value="Fast Food"
                                <?php
                                if ($selectedTag == "Fast Food")
                                    echo "selected";
                                ?>>

                                Fast Food

                            </option>


                            <option value="Extra Protein"
                                <?php
                                if ($selectedTag == "Extra Protein")
                                    echo "selected";
                                ?>>

                                Extra Protein

                            </option>


                            <option value="Drinks"
                                <?php
                                if ($selectedTag == "Drinks")
                                     echo "selected";
                             ?>>

                                Drinks

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
                 FOOD LIST HEADING
                 ========================= -->

            <div class="browse-menu-list-heading">


                <div>

                    <p class="browse-page-label">
                        AVAILABLE ITEMS
                    </p>


                    <h2>

                        <?php

                        if ($selectedTag != "") {

                            echo htmlspecialchars($selectedTag)
                                 . " Food";

                        } else {

                            echo "Full Menu";
                        }

                        ?>

                    </h2>

                </div>


                <span class="restaurant-count">

                    <?php
                    echo mysqli_num_rows($food_result);
                    ?>
                    found

                </span>


            </div>



            <!-- =========================
                 FOOD LIST
                 ========================= -->

            <section class="browse-menu-scroll-area">


                <?php
                if (mysqli_num_rows($food_result) > 0) {
                ?>


                    <?php
                    while ($food = mysqli_fetch_assoc($food_result)) {
                    ?>


                        <article class="browse-food-card">


                            <div class="browse-food-main">


                                <div class="browse-food-top">


                                    <div>

                                        <p class="browse-food-tag">

                                            <?php
                                            echo htmlspecialchars(
                                                $food['food_tag']
                                            );
                                            ?>

                                        </p>


                                        <h3>

                                            <?php
                                            echo htmlspecialchars(
                                                $food['food_name']
                                            );
                                            ?>

                                        </h3>

                                    </div>



                                    <div class="browse-food-price">

                                        Tk.
                                        <?php
                                        echo htmlspecialchars(
                                            $food['price']
                                        );
                                        ?>

                                    </div>


                                </div>



                                <?php
                                if ($food['food_description'] != "") {
                                ?>

                                    <p class="browse-food-description">

                                        <?php
                                        echo htmlspecialchars(
                                            $food['food_description']
                                        );
                                        ?>

                                    </p>

                                <?php } ?>



                                <div class="browse-food-details">


                                    <span>

                                        <strong>Food Type:</strong>

                                        <?php
                                        echo htmlspecialchars(
                                            $food['food_tag']
                                        );
                                        ?>

                                    </span>



                                    <?php
                                    if ($food['calories'] != NULL) {
                                    ?>

                                        <span>

                                            <strong>Calories:</strong>

                                            <?php
                                            echo htmlspecialchars(
                                                $food['calories']
                                            );
                                            ?>
                                            kcal

                                        </span>

                                    <?php } ?>


                                </div>


                            </div>



                            <!-- =========================
                                 ADD TO CART
                                 ========================= -->

                            <form
                                action="browse_menu.php?restaurant_id=<?php
                                echo htmlspecialchars(
                                    $restaurant_id
                                );
                                ?>"
                                method="POST"
                                class="browse-add-cart-form">


                                <input type="hidden"
                                       name="food_id"
                                       value="<?php
                                       echo htmlspecialchars(
                                           $food['food_id']
                                       );
                                       ?>">


                                <div class="browse-quantity-field">

                                    <label for="quantity_<?php
                                        echo $food['food_id'];
                                    ?>">
                                        Qty
                                    </label>


                                    <input
                                        type="number"
                                        id="quantity_<?php
                                        echo $food['food_id'];
                                        ?>"
                                        name="quantity"
                                        value="1"
                                        min="1"
                                        required
                                    >

                                </div>


                                <button type="submit"
                                        name="add_to_cart"
                                        class="browse-add-cart-button">

                                    Add to Cart

                                </button>


                            </form>


                        </article>


                    <?php } ?>


                <?php } else { ?>


                    <div class="restaurant-empty-state">


                        <h3>No food items found</h3>


                        <p>

                            There are currently no available
                            food items for this filter.

                        </p>


                        <a href="browse_menu.php?restaurant_id=<?php
                           echo htmlspecialchars($restaurant_id);
                           ?>">

                            Show Full Menu

                        </a>


                    </div>


                <?php } ?>


            </section>



            <!-- =========================
                 CUSTOMER REVIEWS
                 ========================= -->

            <section class="restaurant-rating-summary">


                <div class="restaurant-rating-summary-left">


                    <p class="restaurant-card-label">
                        CUSTOMER REVIEWS
                    </p>


                    <?php
                    if ($rating_data['rating_count'] > 0) {
                    ?>


                        <div class="restaurant-average-rating">

                            <strong>
                                <?php
                                echo number_format(
                                    $rating_data['average_rating'],
                                    1
                                );
                                ?>
                            </strong>

                            <span>/ 5</span>

                        </div>


                        <div class="restaurant-summary-stars">

                            <?php

                            $rounded_rating =
                                round($rating_data['average_rating']);

                            for ($i = 1; $i <= 5; $i++) {

                                if ($i <= $rounded_rating) {
                                    echo '<span class="filled">★</span>';
                                } else {
                                    echo '<span>★</span>';
                                }
                            }

                            ?>

                        </div>


                    <?php } else { ?>

                        <h2>No ratings yet</h2>

                        <p>Be the first customer to rate this restaurant.</p>

                    <?php } ?>


                </div>


                <div class="restaurant-rating-count-card">

                    <span>TOTAL RATINGS</span>

                    <strong>
                        <?php
                        echo $rating_data['rating_count'];
                        ?>
                    </strong>

                    <small>submitted ratings</small>

                </div>


            </section>



            <section class="restaurant-review-list-heading">

                <div>

                    <p class="restaurant-card-label">
                        CUSTOMER FEEDBACK
                    </p>

                    <h2>Reviews</h2>

                </div>


                <span>
                    <?php
                    $review_count = mysqli_num_rows($review_result);

                    echo $review_count;
                    echo $review_count != 1 ? ' reviews' : ' review';
                    ?>
                </span>

            </section>



            <section class="restaurant-review-list">


                <?php
                if (mysqli_num_rows($review_result) > 0) {
                ?>


                    <?php
                    while ($review =
                        mysqli_fetch_assoc($review_result)) {
                    ?>


                        <article class="restaurant-review-card">


                            <div class="restaurant-review-top">

                                <div class="restaurant-review-customer">

                                    <div class="restaurant-review-avatar">

                                        <?php

                                        $first_letter =
                                            strtoupper(
                                                substr(
                                                    $review['name'],
                                                    0,
                                                    1
                                                )
                                            );

                                        echo htmlspecialchars(
                                            $first_letter
                                        );

                                        ?>

                                    </div>


                                    <div>

                                        <h3>
                                            <?php
                                            echo htmlspecialchars(
                                                $review['name']
                                            );
                                            ?>
                                        </h3>

                                        <p>
                                            @<?php
                                            echo htmlspecialchars(
                                                $review['username']
                                            );
                                            ?>
                                        </p>

                                    </div>

                                </div>


                                <div class="restaurant-review-date">

                                    <?php
                                    echo date(
                                        "d M Y, h:i A",
                                        strtotime(
                                            $review['review_date']
                                        )
                                    );
                                    ?>

                                </div>

                            </div>



                            <div class="restaurant-review-rating-row">

                                <?php
                                if ($review['rating'] !== null) {
                                ?>

                                    <div class="restaurant-review-stars">

                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {

                                            if ($i <= $review['rating']) {
                                                echo '<span class="filled">★</span>';
                                            } else {
                                                echo '<span>★</span>';
                                            }
                                        }
                                        ?>

                                    </div>

                                    <strong>
                                        <?php
                                        echo $review['rating'];
                                        ?>
                                        / 5
                                    </strong>

                                <?php } else { ?>

                                    <span class="restaurant-no-rating">
                                        No rating given
                                    </span>

                                <?php } ?>

                            </div>



                            <div class="restaurant-review-comment">

                                <p class="restaurant-review-section-label">
                                    CUSTOMER COMMENT
                                </p>


                                <?php
                                if ($review['comment'] != '') {
                                ?>

                                    <p>
                                        <?php
                                        echo nl2br(
                                            htmlspecialchars(
                                                $review['comment']
                                            )
                                        );
                                        ?>
                                    </p>

                                <?php } else { ?>

                                    <p class="restaurant-empty-comment">
                                        No comment was provided.
                                    </p>

                                <?php } ?>

                            </div>


                        </article>


                    <?php } ?>


                <?php } else { ?>

                    <div class="restaurant-reviews-empty">

                        <p class="restaurant-card-label">
                            REVIEWS
                        </p>

                        <h2>No reviews yet</h2>

                        <p>
                            Customer ratings and comments will appear here
                            after customers review this restaurant.
                        </p>

                    </div>

                <?php } ?>


            </section>


        </div>


    </main>


</body>

</html>