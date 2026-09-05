<?php

session_start();
require_once('DBconnect.php');

# customer login check
if (!isset($_SESSION['login_id']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'restaurant_owner') {

    header("Location: index.php");
    exit;
}
$restaurant_id = $_SESSION['login_id'];

$message = "";

# fetch restaurant info
$restaurant_query = "SELECT restaurant_name
                     FROM restaurants
                     WHERE login_id = '$restaurant_id'";

$restaurant_result =
    mysqli_query($conn, $restaurant_query);
$restaurant =
    mysqli_fetch_assoc($restaurant_result);

# add coupon
if (isset($_POST['coupon_code']) &&
    isset($_POST['discount_amount'])) {

    $coupon_code = $_POST['coupon_code'];

    $discount_amount =
        $_POST['discount_amount'];


    if ($discount_amount > 0 &&
        $discount_amount <= 100) {
        
# check if coupon code already exists for this restaurant
        $check_query = "SELECT *
                        FROM coupons
                        WHERE restaurant_id = '$restaurant_id'
                        AND coupon_code = '$coupon_code'";
        $check_result =
            mysqli_query(
                $conn,
                $check_query
            );

        if (mysqli_num_rows($check_result) > 0) {

            $message =
                "You already have a coupon with this code.";

        } else {

            $query = "INSERT INTO coupons
                      (
                          discount_amount,
                          coupon_code,
                          restaurant_id
                      )

                      VALUES
                      (
                          '$discount_amount',
                          '$coupon_code',
                          '$restaurant_id'
                      )";


            mysqli_query($conn, $query);
            header(
                "Location: view_res_coupons.php"
            );

            exit;
        }
    } else {
        $message =
            "Discount amount must be between 1 and 100.";
    }
}

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Panda Foods - Add Coupon</title>

    <link rel="stylesheet"
          href="style.css?v=3">

</head>


<body class="restaurant-coupon-page">


    <main class="restaurant-coupon-shell">


        <!-- =========================
             PARTICLES
             ========================= -->

        <div class="restaurant-coupon-particles"
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



        <div class="restaurant-coupon-content">


            <!-- HEADER -->

            <section class="restaurant-management-header">


                <div>

                    <p class="restaurant-management-label">
                        PANDA FOODS
                    </p>


                    <h1>
                        Add Coupon
                    </h1>


                    <p>

                        Create a discount coupon for

                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $restaurant['restaurant_name']
                            );
                            ?>
                        </strong>.

                    </p>

                </div>



                <div class="restaurant-coupon-header-actions">


                    <a href="view_res_coupons.php"
                       class="restaurant-coupon-view-button">

                        View Coupons

                    </a>


                    <a href="restaurant_dashboard.php"
                       class="restaurant-management-back">

                        ← Dashboard

                    </a>


                </div>


            </section>



            <!-- COUPON CARD -->

            <section class="restaurant-coupon-form-card">


                <div class="restaurant-coupon-card-top">


                    <p class="restaurant-card-label">
                        COUPON MANAGEMENT
                    </p>


                    <h2>
                        Create a New Offer
                    </h2>


                    <p>
                        Choose a coupon code and
                        percentage discount.
                    </p>


                </div>



                <?php if ($message != "") { ?>


                    <div class="restaurant-form-message">

                        <?php
                        echo htmlspecialchars($message);
                        ?>

                    </div>


                <?php } ?>



                <form
                    action="res_coupons.php"
                    method="POST"
                    class="restaurant-coupon-form"
                >


                    <!-- COUPON CODE -->

                    <div class="restaurant-form-group">


                        <label for="coupon_code">
                            Coupon Code
                        </label>


                        <input
                            type="text"
                            id="coupon_code"
                            name="coupon_code"
                            placeholder="e.g. PANDA20"
                            required
                        >


                        <small class="restaurant-field-hint">
                            Customers will enter this code
                            when checking out.
                        </small>


                    </div>



                    <!-- DISCOUNT -->

                    <div class="restaurant-form-group">


                        <label for="discount_amount">
                            Discount Percentage
                        </label>


                        <div class="restaurant-percent-input">


                            <input
                                type="number"
                                id="discount_amount"
                                name="discount_amount"
                                min="1"
                                max="100"
                                placeholder="20"
                                required
                            >


                            <span>%</span>


                        </div>


                        <small class="restaurant-field-hint">
                            Enter a value between 1 and 100.
                        </small>


                    </div>



                    <!-- PREVIEW -->

                    <div class="restaurant-coupon-preview">


                        <span>
                            OFFER PREVIEW
                        </span>


                        <strong>
                            Save customers a percentage
                            on their order.
                        </strong>


                        <p>
                            The coupon applies during
                            checkout when the entered code
                            matches this restaurant.
                        </p>


                    </div>



                    <!-- ACTIONS -->

                    <div class="restaurant-coupon-form-actions">


                        <a href="view_res_coupons.php"
                           class="restaurant-secondary-button">

                            Existing Coupons

                        </a>


                        <button
                            type="submit"
                            class="restaurant-primary-button">

                            Add Coupon

                            <span>＋</span>

                        </button>


                    </div>


                </form>


            </section>


        </div>


    </main>


</body>

</html>