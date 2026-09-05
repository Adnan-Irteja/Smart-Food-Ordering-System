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


# delete coupon
if (isset($_POST['delete_coupon'])) {

    $coupon_id = $_POST['coupon_id'];

    $delete_query = "DELETE FROM coupons
                     WHERE coupon_id = '$coupon_id'
                     AND restaurant_id = '$restaurant_id'";

    mysqli_query($conn, $delete_query);

    header("Location: view_res_coupons.php");
    exit;
}


# get restaurant info
$restaurant_query = "SELECT restaurant_name
                     FROM restaurants
                     WHERE login_id = '$restaurant_id'";

$restaurant_result =
    mysqli_query($conn, $restaurant_query);

$restaurant =
    mysqli_fetch_assoc($restaurant_result);


# get coupons for the restaurant
$query = "SELECT
                 coupon_id,
                 coupon_code,
                 discount_amount

          FROM coupons

          WHERE restaurant_id = '$restaurant_id'

          ORDER BY coupon_id DESC";

$result = mysqli_query($conn, $query);

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Panda Foods - Coupons</title>

    <link rel="stylesheet"
          href="style.css?v=4">

</head>


<body class="restaurant-coupon-list-page">


    <main class="restaurant-coupon-list-shell">


        <!-- =========================
             PARTICLES
             ========================= -->

        <div class="restaurant-coupon-list-particles"
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



        <div class="restaurant-coupon-list-content">


            <!-- =========================
                 HEADER
                 ========================= -->

            <section class="restaurant-management-header">


                <div>

                    <p class="restaurant-management-label">
                        PANDA FOODS
                    </p>


                    <h1>
                        Coupons
                    </h1>


                    <p>

                        View and manage the current discount offers
                        from

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


                    <a href="res_coupons.php"
                       class="restaurant-coupon-view-button">

                        ＋ Add Coupon

                    </a>


                    <a href="restaurant_dashboard.php"
                       class="restaurant-management-back">

                        ← Dashboard

                    </a>


                </div>


            </section>



            <!-- =========================
                 SUMMARY
                 ========================= -->

            <section class="restaurant-coupon-list-summary">


                <div>

                    <p class="restaurant-card-label">
                        ACTIVE OFFERS
                    </p>


                    <h2>
                        Coupon List
                    </h2>

                </div>


                <span>

                    <?php
                    echo mysqli_num_rows($result);
                    ?>

                    coupon<?php
                    echo mysqli_num_rows($result) != 1
                        ? 's'
                        : '';
                    ?>

                </span>


            </section>



            <!-- =========================
                 COUPON LIST
                 ========================= -->

            <section class="restaurant-coupon-scroll-area">


                <?php
                if (mysqli_num_rows($result) > 0) {
                ?>


                    <?php
                    while ($coupon =
                        mysqli_fetch_assoc($result)) {
                    ?>


                        <article class="restaurant-coupon-card">


                            <!-- =========================
                                 LEFT SIDE
                                 ========================= -->

                            <div class="restaurant-coupon-card-left">


                                <p>
                                    COUPON CODE
                                </p>


                                <h2>

                                    <?php
                                    echo htmlspecialchars(
                                        $coupon['coupon_code']
                                    );
                                    ?>

                                </h2>


                                <span>

                                    Coupon ID #
                                    <?php
                                    echo $coupon['coupon_id'];
                                    ?>

                                </span>


                            </div>



                            <!-- =========================
                                 DISCOUNT + DELETE
                                 ========================= -->

                            <div class="restaurant-coupon-discount">


                                <span>
                                    SAVE
                                </span>


                                <strong>

                                    <?php
                                    echo $coupon['discount_amount'];
                                    ?>%

                                </strong>


                                <small>
                                    discount
                                </small>



                                <form
                                    action="view_res_coupons.php"
                                    method="POST"
                                    onsubmit="return confirm(
                                        'Are you sure you want to delete this coupon?'
                                    );"
                                >


                                    <input
                                        type="hidden"
                                        name="coupon_id"
                                        value="<?php
                                        echo $coupon['coupon_id'];
                                        ?>"
                                    >


                                    <button
                                        type="submit"
                                        name="delete_coupon"
                                        class="restaurant-coupon-delete-button"
                                    >

                                        Delete Coupon

                                    </button>


                                </form>


                            </div>


                        </article>


                    <?php } ?>


                <?php } else { ?>


                    <!-- =========================
                         EMPTY STATE
                         ========================= -->

                    <div class="restaurant-coupon-empty">


                        <p class="restaurant-card-label">
                            COUPONS
                        </p>


                        <h2>
                            No coupons yet
                        </h2>


                        <p>
                            Create your first discount
                            offer for customers.
                        </p>


                        <a href="res_coupons.php">

                            ＋ Create Coupon

                        </a>


                    </div>


                <?php } ?>


            </section>


        </div>


    </main>


</body>

</html>