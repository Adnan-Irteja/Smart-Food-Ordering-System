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

# get restaurant info
$restaurant_query = "SELECT restaurant_name
                     FROM restaurants
                     WHERE login_id = '$restaurant_id'";

$restaurant_result =
    mysqli_query($conn, $restaurant_query);

$restaurant =
    mysqli_fetch_assoc($restaurant_result);

# get average rating and total number of ratings
$average_query = "SELECT
                         AVG(rating) AS average_rating,
                         COUNT(rating) AS rating_count

                  FROM reviews

                  WHERE restaurant_id = '$restaurant_id'
                  AND rating IS NOT NULL";

$average_result =
    mysqli_query($conn, $average_query);
$average_data =
    mysqli_fetch_assoc($average_result);

    # get all reviews for the restaurant
$review_query = "SELECT
                        r.review_id,
                        r.rating,
                        r.comment,
                        r.review_date,
                        c.name,
                        c.username

                 FROM reviews r

                 JOIN customers c
                 ON r.customer_id = c.login_id

                 WHERE r.restaurant_id = '$restaurant_id'

                 ORDER BY r.review_date DESC";

$review_result =
    mysqli_query($conn, $review_query);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Panda Foods - Restaurant Reviews</title>

    <link rel="stylesheet"
          href="style.css?v=3">

</head>


<body class="restaurant-reviews-page">


    <main class="restaurant-reviews-shell">


        <!-- =========================
             FLOATING PARTICLES
             ========================= -->

        <div class="restaurant-reviews-particles"
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



        <div class="restaurant-reviews-content">


            <!-- =========================
                 HEADER
                 ========================= -->

            <section class="restaurant-management-header">


                <div>

                    <p class="restaurant-management-label">
                        PANDA FOODS
                    </p>


                    <h1>
                        Customer Reviews
                    </h1>


                    <p>

                        See what customers are saying about

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

                    ← Dashboard

                </a>


            </section>



            <!-- =========================
                 RATING SUMMARY
                 ========================= -->

            <section class="restaurant-rating-summary">


                <div class="restaurant-rating-summary-left">


                    <p class="restaurant-card-label">
                        RATING SUMMARY
                    </p>


                    <?php
                    if ($average_data['rating_count'] > 0) {
                    ?>


                        <div class="restaurant-average-rating">


                            <strong>

                                <?php

                                echo number_format(
                                    $average_data['average_rating'],
                                    1
                                );

                                ?>

                            </strong>


                            <span>
                                / 5
                            </span>


                        </div>


                        <div class="restaurant-summary-stars">


                            <?php

                            $rounded_rating =
                                round(
                                    $average_data['average_rating']
                                );


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


                        <h2>
                            No ratings yet
                        </h2>


                        <p>
                            Customer ratings will appear here.
                        </p>


                    <?php } ?>


                </div>



                <div class="restaurant-rating-count-card">


                    <span>
                        TOTAL RATINGS
                    </span>


                    <strong>

                        <?php
                        echo $average_data['rating_count'];
                        ?>

                    </strong>


                    <small>
                        submitted ratings
                    </small>


                </div>


            </section>



            <!-- =========================
                 REVIEW LIST HEADING
                 ========================= -->

            <section class="restaurant-review-list-heading">


                <div>

                    <p class="restaurant-card-label">
                        CUSTOMER FEEDBACK
                    </p>


                    <h2>
                        All Reviews
                    </h2>

                </div>


                <span>

                    <?php
                    echo mysqli_num_rows($review_result);
                    ?>

                    review<?php
                    echo mysqli_num_rows($review_result) != 1
                        ? 's'
                        : '';
                    ?>

                </span>


            </section>



            <!-- =========================
                 SCROLLABLE REVIEW LIST
                 ========================= -->

            <section class="restaurant-review-list">


                <?php
                if (mysqli_num_rows($review_result) > 0) {
                ?>


                    <?php
                    while ($review =
                        mysqli_fetch_assoc($review_result)) {
                    ?>


                        <article class="restaurant-review-card">


                            <!-- TOP -->

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



                            <!-- RATING -->

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



                            <!-- COMMENT -->

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



                            <!-- REVIEW ID -->

                            <div class="restaurant-review-footer">

                                Review #
                                <?php
                                echo $review['review_id'];
                                ?>

                            </div>


                        </article>


                    <?php } ?>


                <?php } else { ?>


                    <!-- =========================
                         EMPTY STATE
                         ========================= -->

                    <div class="restaurant-reviews-empty">


                        <p class="restaurant-card-label">
                            REVIEWS
                        </p>


                        <h2>
                            No reviews yet
                        </h2>


                        <p>
                            Customer ratings and comments
                            will appear here after they
                            review your restaurant.
                        </p>


                        <a href="restaurant_dashboard.php">

                            Back to Dashboard

                        </a>


                    </div>


                <?php } ?>


            </section>


        </div>


    </main>


</body>

</html>