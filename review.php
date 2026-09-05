<?php

session_start();
require_once('DBconnect.php');

# check user login
if (!isset($_SESSION['login_id']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'user') {

    header("Location: index.php");
    exit;
}
$customer_id = $_SESSION['login_id'];

# get restaurant id
if (isset($_GET['restaurant_id'])) {
    $restaurant_id = $_GET['restaurant_id'];

} elseif (isset($_POST['restaurant_id'])) {

    $restaurant_id = $_POST['restaurant_id'];

} else {
    header("Location: customer_order.php");
    exit;
}

$restaurant_query = "SELECT restaurant_name
                     FROM restaurants
                     WHERE login_id = '$restaurant_id'";

$restaurant_result = mysqli_query($conn, $restaurant_query);

if (mysqli_num_rows($restaurant_result) == 0) {

    header("Location: customer_order.php");
    exit;
}

$restaurant = mysqli_fetch_assoc($restaurant_result);

# check for existing review
$review_query = "SELECT *
                 FROM reviews
                 WHERE customer_id = '$customer_id'
                 AND restaurant_id = '$restaurant_id'";

$review_result = mysqli_query($conn, $review_query);

$existing_review = null;

if (mysqli_num_rows($review_result) > 0) {
    $existing_review =
        mysqli_fetch_assoc($review_result);
}

# submit review
if (isset($_POST['submit_review'])) {

    $rating = $_POST['rating'] ?? '';

    $comment =
        trim($_POST['comment'] ?? '');

    $comment =
        mysqli_real_escape_string(
            $conn,
            $comment
        );

        # saving only if customer entered smth
    if ($rating != '' ||
        $comment != '') {

        #update existing review
        if ($existing_review) {

            if ($rating == '') {

                $rating_value = "NULL";

            } else {

                $rating_value = "'$rating'";
            }

            $query = "UPDATE reviews

                      SET rating = $rating_value,
                          comment = '$comment',
                          review_date = NOW()

                      WHERE customer_id = '$customer_id'
                      AND restaurant_id = '$restaurant_id'";

            mysqli_query($conn, $query);

            # new review insertion
        } else {

            if ($rating == '') {

                $rating_value = "NULL";

            } else {

                $rating_value = "'$rating'";
            }
            $query = "INSERT INTO reviews

                      (rating,
                       comment,
                       review_date,
                       customer_id,
                       restaurant_id)

                      VALUES

                      ($rating_value,
                       '$comment',
                       NOW(),
                       '$customer_id',
                       '$restaurant_id')";

            mysqli_query($conn, $query);
        }
    }
    // Return to active orders
    header("Location: customer_order.php");
    exit;
}

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Panda Foods - Leave a Review</title>

    <link rel="stylesheet"
          href="style.css?v=3">

</head>


<body class="review-page">


    <main class="review-shell">


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



        <div class="review-content">


            <!-- =========================
                 HEADER
                 ========================= -->

            <section class="review-header">


                <div>

                    <p class="browse-page-label">
                        Panda Foods
                    </p>


                    <h1>
                        How was your order?
                    </h1>


                    <p>

                        Tell us about your experience
                        with

                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $restaurant['restaurant_name']
                            );
                            ?>
                        </strong>.

                    </p>

                </div>


                <a href="customer_order.php"
                   class="browse-back-button">

                    ← Back to Orders

                </a>


            </section>



            <!-- =========================
                 REVIEW CARD
                 ========================= -->

            <section class="review-card">


                <div class="review-card-top">


                    <p class="review-card-label">
                        YOUR FEEDBACK
                    </p>


                    <h2>

                        <?php
                        echo htmlspecialchars(
                            $restaurant['restaurant_name']
                        );
                        ?>

                    </h2>


                    <p>

                        Rating and comment are optional.
                        Share as much or as little as you like.

                    </p>


                </div>



                <?php if ($existing_review) { ?>


                    <div class="review-existing-message">

                        <strong>
                            You've reviewed this restaurant before.
                        </strong>

                        <span>
                            Saving will update your previous review.
                        </span>

                    </div>


                <?php } ?>



                <form action="review.php"
                      method="POST"
                      class="review-form">


                    <input
                        type="hidden"
                        name="restaurant_id"
                        value="<?php
                        echo htmlspecialchars(
                            $restaurant_id
                        );
                        ?>"
                    >



                    <!-- =========================
                         RATING
                         ========================= -->

                    <div class="review-section">


                        <div class="review-section-heading">

                            <span>RATING</span>

                            <h3>
                                Rate your experience
                            </h3>

                            <p>
                                Select from 1 to 5 stars.
                            </p>

                        </div>



                        <div class="review-rating-options">


                            <!-- 1 STAR -->

                            <input
                                type="radio"
                                id="rating1"
                                name="rating"
                                value="1"

                                <?php

                                if ($existing_review &&
                                    $existing_review['rating'] == 1) {

                                    echo "checked";
                                }

                                ?>
                            >


                            <label for="rating1">

                                <span class="review-star">
                                    ★
                                </span>

                                <strong>1</strong>

                                <small>Poor</small>

                            </label>



                            <!-- 2 STARS -->

                            <input
                                type="radio"
                                id="rating2"
                                name="rating"
                                value="2"

                                <?php

                                if ($existing_review &&
                                    $existing_review['rating'] == 2) {

                                    echo "checked";
                                }

                                ?>
                            >


                            <label for="rating2">

                                <span class="review-star">
                                    ★
                                </span>

                                <strong>2</strong>

                                <small>Fair</small>

                            </label>



                            <!-- 3 STARS -->

                            <input
                                type="radio"
                                id="rating3"
                                name="rating"
                                value="3"

                                <?php

                                if ($existing_review &&
                                    $existing_review['rating'] == 3) {

                                    echo "checked";
                                }

                                ?>
                            >


                            <label for="rating3">

                                <span class="review-star">
                                    ★
                                </span>

                                <strong>3</strong>

                                <small>Good</small>

                            </label>



                            <!-- 4 STARS -->

                            <input
                                type="radio"
                                id="rating4"
                                name="rating"
                                value="4"

                                <?php

                                if ($existing_review &&
                                    $existing_review['rating'] == 4) {

                                    echo "checked";
                                }

                                ?>
                            >


                            <label for="rating4">

                                <span class="review-star">
                                    ★
                                </span>

                                <strong>4</strong>

                                <small>Great</small>

                            </label>



                            <!-- 5 STARS -->

                            <input
                                type="radio"
                                id="rating5"
                                name="rating"
                                value="5"

                                <?php

                                if ($existing_review &&
                                    $existing_review['rating'] == 5) {

                                    echo "checked";
                                }

                                ?>
                            >


                            <label for="rating5">

                                <span class="review-star">
                                    ★
                                </span>

                                <strong>5</strong>

                                <small>Excellent</small>

                            </label>


                        </div>


                    </div>



                    <div class="review-divider"></div>



                    <!-- =========================
                         COMMENT
                         ========================= -->

                    <div class="review-section">


                        <div class="review-section-heading">

                            <span>COMMENT</span>

                            <h3>
                                Tell us more
                            </h3>

                            <p>
                                What did you like?
                                Was there anything that could be better?
                            </p>

                        </div>



                        <div class="review-comment-box">


                            <textarea
                                id="comment"
                                name="comment"
                                maxlength="500"
                                placeholder="Write something about your experience..."
                            ><?php

                                if ($existing_review) {

                                    echo htmlspecialchars(
                                        $existing_review['comment']
                                    );
                                }

                            ?></textarea>


                            <span>
                                Maximum 500 characters
                            </span>


                        </div>


                    </div>



                    <!-- =========================
                         BUTTONS
                         ========================= -->

                    <div class="review-actions">


                        <a href="customer_order.php"
                           class="review-skip-button">

                            <?php

                            if ($existing_review) {

                                echo "Cancel";

                            } else {

                                echo "Skip for Now";
                            }

                            ?>

                        </a>


                        <button
                            type="submit"
                            name="submit_review"
                            class="review-submit-button"
                        >

                            <?php

                            if ($existing_review) {

                                echo "Update Review";

                            } else {

                                echo "Save & Continue";
                            }

                            ?>

                            <span>→</span>

                        </button>


                    </div>


                </form>


            </section>


        </div>


    </main>


</body>

</html>