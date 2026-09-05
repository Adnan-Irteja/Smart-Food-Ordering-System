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


$customer_id = $_SESSION['login_id'];


// =========================
// GET RESTAURANT ID
// =========================

if (isset($_GET['restaurant_id'])) {

    $restaurant_id = $_GET['restaurant_id'];

} elseif (isset($_POST['restaurant_id'])) {

    $restaurant_id = $_POST['restaurant_id'];

} else {

    header("Location: customer_order.php");
    exit;
}


// =========================
// GET RESTAURANT INFORMATION
// =========================

$restaurant_query = "SELECT restaurant_name
                     FROM restaurants
                     WHERE login_id = '$restaurant_id'";

$restaurant_result = mysqli_query($conn, $restaurant_query);


if (mysqli_num_rows($restaurant_result) == 0) {

    header("Location: customer_order.php");
    exit;
}


$restaurant = mysqli_fetch_assoc($restaurant_result);


// =========================
// CHECK FOR EXISTING REVIEW
// =========================

$review_query = "SELECT *
                 FROM reviews
                 WHERE customer_id = '$customer_id'
                 AND restaurant_id = '$restaurant_id'";

$review_result = mysqli_query($conn, $review_query);


$existing_review = null;

if (mysqli_num_rows($review_result) > 0) {

    $existing_review = mysqli_fetch_assoc($review_result);
}


// =========================
// SUBMIT REVIEW
// =========================

if (isset($_POST['submit_review'])) {

    $rating = $_POST['rating'] ?? '';
    $comment = trim($_POST['comment'] ?? '');

    $comment = mysqli_real_escape_string($conn, $comment);


    // Only save something if rating or comment was provided
    if ($rating != '' || $comment != '') {

        // =========================
        // UPDATE EXISTING REVIEW
        // =========================

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


        // =========================
        // INSERT NEW REVIEW
        // =========================

        } else {

            if ($rating == '') {
                $rating_value = "NULL";
            } else {
                $rating_value = "'$rating'";
            }


            $query = "INSERT INTO reviews
                      (rating, comment, review_date,
                       customer_id, restaurant_id)

                      VALUES
                      ($rating_value, '$comment', NOW(),
                       '$customer_id', '$restaurant_id')";

            mysqli_query($conn, $query);
        }
    }


    // Whether they reviewed or skipped,
    // return to active orders
    header("Location: customer_order.php");
    exit;
}

?>


<!DOCTYPE html>
<html>

<head>

    <title>Leave a Review</title>

</head>


<body>


    <h1>Leave a Review</h1>


    <h2>
        <?php echo htmlspecialchars($restaurant['restaurant_name']); ?>
    </h2>


    <form action="review.php" method="POST">


        <input
            type="hidden"
            name="restaurant_id"
            value="<?php echo $restaurant_id; ?>"
        >


        <!-- =========================
             RATING
             ========================= -->

        <h3>Rating</h3>


        <label>

            <input
                type="radio"
                name="rating"
                value="1"

                <?php
                if ($existing_review &&
                    $existing_review['rating'] == 1) {
                    echo "checked";
                }
                ?>
            >

            1 Star

        </label>


        <br>


        <label>

            <input
                type="radio"
                name="rating"
                value="2"

                <?php
                if ($existing_review &&
                    $existing_review['rating'] == 2) {
                    echo "checked";
                }
                ?>
            >

            2 Stars

        </label>


        <br>


        <label>

            <input
                type="radio"
                name="rating"
                value="3"

                <?php
                if ($existing_review &&
                    $existing_review['rating'] == 3) {
                    echo "checked";
                }
                ?>
            >

            3 Stars

        </label>


        <br>


        <label>

            <input
                type="radio"
                name="rating"
                value="4"

                <?php
                if ($existing_review &&
                    $existing_review['rating'] == 4) {
                    echo "checked";
                }
                ?>
            >

            4 Stars

        </label>


        <br>


        <label>

            <input
                type="radio"
                name="rating"
                value="5"

                <?php
                if ($existing_review &&
                    $existing_review['rating'] == 5) {
                    echo "checked";
                }
                ?>
            >

            5 Stars

        </label>


        <br><br>


        <!-- =========================
             COMMENT
             ========================= -->

        <h3>Your Comment</h3>


        <textarea
            name="comment"
            rows="6"
            cols="50"
            maxlength="500"
            placeholder="Write something about your experience..."
        ><?php
            if ($existing_review) {
                echo htmlspecialchars($existing_review['comment']);
            }
        ?></textarea>


        <br><br>


        <!-- =========================
             SUBMIT / CONTINUE
             ========================= -->

        <button
            type="submit"
            name="submit_review"
        >
            Save & Continue
        </button>


    </form>


</body>

</html>