<?php

session_start();
require_once('DBconnect.php');

# check customer login
if (!isset($_SESSION['login_id']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'user') {

    header("Location: index.php");
    exit;
}

$customer_id = $_SESSION['login_id'];

# confirm order received
if (isset($_POST['confirm_order'])) {

    $order_id = $_POST['order_id'];
    $restaurant_id = $_POST['restaurant_id'];

    $query = "UPDATE orders o
              JOIN order_items oi
              ON o.order_id = oi.order_id

              SET o.order_status = 'Confirmed'

              WHERE o.order_id = '$order_id'
              AND oi.customer_id = '$customer_id'
              AND o.order_status = 'Delivering'";

    mysqli_query($conn, $query);

    // After confirming receipt,
    // send customer to review page
    header("Location: review.php?restaurant_id=$restaurant_id");
    exit;
}

# get active orders
$query = "SELECT DISTINCT
                 o.order_id,
                 o.order_datetime,
                 o.order_status,
                 o.total_price,
                 o.restaurant_id,
                 r.restaurant_name

          FROM orders o

          JOIN order_items oi
          ON o.order_id = oi.order_id
          AND oi.customer_id = '$customer_id'

          JOIN restaurants r
          ON o.restaurant_id = r.login_id

          WHERE o.order_status = 'Pending'
             OR o.order_status = 'Delivering'

          ORDER BY o.order_datetime DESC";

$result = mysqli_query($conn, $query);

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Panda Foods - Delivery Status</title>

    <link rel="stylesheet"
          href="style.css?v=2">

</head>


<body class="customer-orders-page">


    <main class="customer-orders-shell">


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



        <div class="customer-orders-content">


            <!-- =========================
                 HEADER
                 ========================= -->

            <section class="customer-orders-header">


                <div>

                    <p class="browse-page-label">
                        Panda Foods
                    </p>

                    <h1>Delivery Status</h1>

                    <p>
                        Follow your active orders and
                        confirm when your food arrives.
                    </p>

                </div>


                <a href="user_dashboard.php"
                   class="browse-back-button">

                    ← Back to Dashboard

                </a>


            </section>



            <!-- =========================
                 PAGE SUMMARY
                 ========================= -->

            <section class="customer-orders-summary">

                <div>

                    <span>ACTIVE ORDERS</span>

                    <strong>
                        <?php echo mysqli_num_rows($result); ?>
                    </strong>

                </div>


                <p>

                    Orders will appear here while they are
                    waiting for the restaurant or currently
                    being delivered.

                </p>

            </section>



            <!-- =========================
                 ORDER LIST
                 ========================= -->

            <section class="customer-orders-list">


                <?php if (mysqli_num_rows($result) > 0) { ?>


                    <?php while ($order = mysqli_fetch_assoc($result)) { ?>


                        <?php

                        $order_id = $order['order_id'];

                        $item_query = "SELECT
                                              oi.quantity,
                                              oi.unit_price,
                                              f.food_name

                                       FROM order_items oi

                                       JOIN fooditems f
                                       ON oi.food_id = f.food_id

                                       WHERE oi.order_id = '$order_id'
                                       AND oi.customer_id = '$customer_id'";

                        $item_result =
                            mysqli_query($conn, $item_query);

                        ?>


                        <article class="customer-order-card">


                            <!-- =========================
                                 ORDER TOP
                                 ========================= -->

                            <div class="customer-order-top">


                                <div>

                                    <p class="customer-order-number">
                                        ORDER #<?php
                                        echo $order['order_id'];
                                        ?>
                                    </p>


                                    <h2>
                                        <?php
                                        echo htmlspecialchars(
                                            $order['restaurant_name']
                                        );
                                        ?>
                                    </h2>


                                    <p class="customer-order-date">

                                        Ordered
                                        <?php
                                        echo date(
                                            "M j, Y · g:i A",
                                            strtotime(
                                                $order['order_datetime']
                                            )
                                        );
                                        ?>

                                    </p>

                                </div>



                                <div class="customer-order-status
                                    <?php
                                    echo strtolower(
                                        $order['order_status']
                                    );
                                    ?>">

                                    <?php
                                    echo htmlspecialchars(
                                        $order['order_status']
                                    );
                                    ?>

                                </div>


                            </div>



                            <!-- =========================
                                 TRACKER
                                 ========================= -->

                            <div class="order-tracker">


                                <!-- PENDING -->

                                <div class="tracker-step active">

                                    <div class="tracker-dot">
                                        1
                                    </div>

                                    <span>Pending</span>

                                </div>



                                <div class="tracker-line
                                    <?php
                                    if ($order['order_status']
                                        == 'Delivering') {

                                        echo 'active';
                                    }
                                    ?>">
                                </div>



                                <!-- DELIVERING -->

                                <div class="tracker-step
                                    <?php
                                    if ($order['order_status']
                                        == 'Delivering') {

                                        echo 'active';
                                    }
                                    ?>">

                                    <div class="tracker-dot">
                                        2
                                    </div>

                                    <span>Delivering</span>

                                </div>



                                <div class="tracker-line"></div>



                                <!-- RECEIVED -->

                                <div class="tracker-step">

                                    <div class="tracker-dot">
                                        3
                                    </div>

                                    <span>Received</span>

                                </div>


                            </div>



                            <!-- =========================
                                 STATUS MESSAGE
                                 ========================= -->

                            <div class="customer-order-status-message">


                                <?php
                                if ($order['order_status']
                                    == 'Pending') {
                                ?>

                                    <strong>
                                        Waiting for the restaurant
                                    </strong>

                                    <span>
                                        Your order has been placed
                                        and is waiting to be processed.
                                    </span>


                                <?php } else { ?>


                                    <strong>
                                        Your food is on the way
                                    </strong>

                                    <span>
                                        Confirm the order once
                                        you have received it.
                                    </span>


                                <?php } ?>


                            </div>



                            <!-- =========================
                                 ITEMS
                                 ========================= -->

                            <div class="customer-order-items">


                                <p class="customer-order-section-label">
                                    ORDER ITEMS
                                </p>


                                <?php
                                while ($item =
                                    mysqli_fetch_assoc(
                                        $item_result
                                    )) {
                                ?>


                                    <div class="customer-order-item-row">


                                        <div>

                                            <strong>
                                                <?php
                                                echo htmlspecialchars(
                                                    $item['food_name']
                                                );
                                                ?>
                                            </strong>


                                            <span>

                                                Quantity:
                                                <?php
                                                echo $item['quantity'];
                                                ?>

                                            </span>

                                        </div>


                                        <strong>

                                            Tk.
                                            <?php
                                            echo $item['unit_price']
                                                 * $item['quantity'];
                                            ?>

                                        </strong>


                                    </div>


                                <?php } ?>


                            </div>



                            <!-- =========================
                                 ORDER BOTTOM
                                 ========================= -->

                            <div class="customer-order-bottom">


                                <div class="customer-order-total">

                                    <span>Order Total</span>

                                    <strong>

                                        Tk.
                                        <?php
                                        echo $order['total_price'];
                                        ?>

                                    </strong>

                                </div>



                                <?php
                                if ($order['order_status']
                                    == 'Delivering') {
                                ?>


                                    <form
                                        action="customer_order.php"
                                        method="POST">


                                        <input
                                            type="hidden"
                                            name="order_id"
                                            value="<?php
                                            echo $order['order_id'];
                                            ?>"
                                        >


                                        <input
                                            type="hidden"
                                            name="restaurant_id"
                                            value="<?php
                                            echo $order['restaurant_id'];
                                            ?>"
                                        >


                                        <button
                                            type="submit"
                                            name="confirm_order"
                                            class="confirm-received-button"
                                        >

                                            Confirm Received

                                            <span>✓</span>

                                        </button>


                                    </form>


                                <?php } ?>


                            </div>


                        </article>


                    <?php } ?>


                <?php } else { ?>


                    <!-- =========================
                         EMPTY STATE
                         ========================= -->

                    <div class="customer-orders-empty">


                        <p class="browse-page-label">
                            ACTIVE ORDERS
                        </p>


                        <h2>
                            Nothing on the way right now
                        </h2>


                        <p>

                            You don't currently have any
                            pending or delivering orders.

                        </p>


                        <a href="browse_restaurants.php">

                            Browse Restaurants →

                        </a>


                    </div>


                <?php } ?>


            </section>


        </div>


    </main>


</body>

</html>