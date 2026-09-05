<?php

session_start();
require_once('DBconnect.php');


// =========================
// CHECK RESTAURANT LOGIN
// =========================

if (!isset($_SESSION['login_id']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'restaurant_owner') {

    header("Location: index.php");
    exit;
}


$restaurant_id = $_SESSION['login_id'];


// =========================
// GET RESTAURANT INFORMATION
// =========================

$restaurant_query = "SELECT restaurant_name
                     FROM restaurants
                     WHERE login_id = '$restaurant_id'";

$restaurant_result = mysqli_query($conn, $restaurant_query);

$restaurant = mysqli_fetch_assoc($restaurant_result);


// =========================
// GET AVERAGE RATING
// =========================

$average_query = "SELECT
                         AVG(rating) AS average_rating,
                         COUNT(rating) AS rating_count

                  FROM reviews

                  WHERE restaurant_id = '$restaurant_id'
                  AND rating IS NOT NULL";

$average_result = mysqli_query($conn, $average_query);

$average_data = mysqli_fetch_assoc($average_result);


// =========================
// GET ALL REVIEWS
// =========================

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

$review_result = mysqli_query($conn, $review_query);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Restaurant Reviews</title>

</head>


<body>


    <h1>
        Reviews for
        <?php echo htmlspecialchars($restaurant['restaurant_name']); ?>
    </h1>


    <!-- =========================
         RATING SUMMARY
         ========================= -->

    <h2>Rating Summary</h2>


    <?php if ($average_data['rating_count'] > 0) { ?>


        <p>

            <strong>Average Rating:</strong>

            <?php
            echo number_format($average_data['average_rating'], 1);
            ?>

            / 5

        </p>


        <p>

            <strong>Total Ratings:</strong>

            <?php echo $average_data['rating_count']; ?>

        </p>


    <?php } else { ?>


        <p>No ratings yet.</p>


    <?php } ?>


    <hr>


    <!-- =========================
         REVIEW LIST
         ========================= -->

    <h2>Customer Reviews</h2>


    <?php if (mysqli_num_rows($review_result) > 0) { ?>


        <?php while ($review = mysqli_fetch_assoc($review_result)) { ?>


            <div>


                <p>

                    <strong>Customer:</strong>

                    <?php echo htmlspecialchars($review['name']); ?>

                    (<?php echo htmlspecialchars($review['username']); ?>)

                </p>


                <p>

                    <strong>Rating:</strong>

                    <?php

                    if ($review['rating'] !== null) {

                        echo $review['rating'] . " / 5";

                    } else {

                        echo "No rating given";
                    }

                    ?>

                </p>


                <p>

                    <strong>Comment:</strong>

                    <?php

                    if ($review['comment'] != '') {

                        echo nl2br(
                            htmlspecialchars($review['comment'])
                        );

                    } else {

                        echo "No comment given";
                    }

                    ?>

                </p>


                <p>

                    <strong>Date:</strong>

                    <?php echo $review['review_date']; ?>

                </p>


                <hr>


            </div>


        <?php } ?>


    <?php } else { ?>


        <p>No reviews have been submitted yet.</p>


    <?php } ?>


    <br>


    <a href="restaurant_dashboard.php">
        Back to Dashboard
    </a>


</body>

</html>