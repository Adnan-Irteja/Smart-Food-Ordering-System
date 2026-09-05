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

# update order status
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    if ($status == 'Delivering' ||
        $status == 'Cancelled') {

        $query = "UPDATE orders
                  SET order_status = '$status'

                  WHERE order_id = '$order_id'
                  AND restaurant_id = '$restaurant_id'";

        mysqli_query($conn, $query);
    }
    header("Location: restaurant_orders.php");
    exit;
}

# get active orders
$query = "SELECT *
          FROM orders

          WHERE restaurant_id = '$restaurant_id'

          AND (
              order_status = 'Pending'
              OR order_status = 'Delivering'
          )

          ORDER BY order_datetime DESC";

$result = mysqli_query($conn, $query);

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Panda Foods - Restaurant Orders</title>

    <link rel="stylesheet"
          href="style.css?v=3">

</head>


<body class="restaurant-orders-page">


    <main class="restaurant-orders-shell">


        <!-- =========================
             FLOATING PARTICLES
             ========================= -->

        <div class="restaurant-orders-particles"
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



        <div class="restaurant-orders-content">


            <!-- =========================
                 HEADER
                 ========================= -->

            <section class="restaurant-management-header">


                <div>

                    <p class="restaurant-management-label">
                        PANDA FOODS
                    </p>


                    <h1>
                        Restaurant Orders
                    </h1>


                    <p>

                        Manage active customer orders for

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
                 SUMMARY
                 ========================= -->

            <section class="restaurant-orders-summary">


                <div>

                    <p class="restaurant-card-label">
                        ACTIVE ORDERS
                    </p>


                    <h2>
                        Incoming Orders
                    </h2>

                </div>


                <span>

                    <?php
                    echo mysqli_num_rows($result);
                    ?>

                    order<?php
                    echo mysqli_num_rows($result) != 1
                        ? 's'
                        : '';
                    ?>

                </span>


            </section>



            <!-- =========================
                 ORDER LIST
                 ========================= -->

            <section class="restaurant-orders-list">


                <?php
                if (mysqli_num_rows($result) > 0) {
                ?>


                    <?php
                    while ($order =
                        mysqli_fetch_assoc($result)) {
                    ?>


                        <article class="restaurant-order-card">


                            <!-- TOP -->

                            <div class="restaurant-order-top">


                                <div>

                                    <p class="restaurant-order-number">

                                        ORDER #
                                        <?php
                                        echo $order['order_id'];
                                        ?>

                                    </p>


                                    <h2>
                                        Customer Order
                                    </h2>


                                    <p class="restaurant-order-date">

                                        <?php

                                        echo date(
                                            "d M Y, h:i A",
                                            strtotime(
                                                $order['order_datetime']
                                            )
                                        );

                                        ?>

                                    </p>

                                </div>



                                <span class="restaurant-order-status
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

                                </span>


                            </div>



                            <!-- STATUS FLOW -->

                            <div class="restaurant-order-progress">


                                <div class="restaurant-order-step active">

                                    <span>1</span>

                                    <small>
                                        Pending
                                    </small>

                                </div>


                                <div class="restaurant-order-progress-line
                                    <?php
                                    if ($order['order_status']
                                        == 'Delivering') {

                                        echo 'active';
                                    }
                                    ?>">
                                </div>


                                <div class="restaurant-order-step
                                    <?php
                                    if ($order['order_status']
                                        == 'Delivering') {

                                        echo 'active';
                                    }
                                    ?>">

                                    <span>2</span>

                                    <small>
                                        Delivering
                                    </small>

                                </div>


                                <div class="restaurant-order-progress-line">
                                </div>


                                <div class="restaurant-order-step">

                                    <span>3</span>

                                    <small>
                                        Received
                                    </small>

                                </div>


                            </div>



                            <!-- ITEMS -->

                            <div class="restaurant-order-items">


                                <p class="restaurant-order-section-label">
                                    ITEMS ORDERED
                                </p>


                                <?php

                                $order_id =
                                    $order['order_id'];


                                $item_query = "SELECT
                                                     oi.quantity,
                                                     oi.unit_price,
                                                     f.food_name

                                              FROM order_items oi

                                              JOIN fooditems f
                                              ON oi.food_id = f.food_id

                                              WHERE oi.order_id = '$order_id'";


                                $item_result =
                                    mysqli_query(
                                        $conn,
                                        $item_query
                                    );

                                ?>


                                <?php
                                while ($item =
                                    mysqli_fetch_assoc($item_result)) {
                                ?>


                                    <div class="restaurant-order-item-row">


                                        <div>

                                            <strong>

                                                <?php
                                                echo htmlspecialchars(
                                                    $item['food_name']
                                                );
                                                ?>

                                            </strong>


                                            <span>

                                                ×
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



                            <!-- BOTTOM -->

                            <div class="restaurant-order-bottom">


                                <div class="restaurant-order-total">


                                    <span>
                                        Order Total
                                    </span>


                                    <strong>

                                        Tk.
                                        <?php
                                        echo $order['total_price'];
                                        ?>

                                    </strong>


                                </div>



                                <!-- ACTIONS -->

                                <form
                                    action="restaurant_orders.php"
                                    method="POST"
                                    class="restaurant-order-actions"
                                >


                                    <input
                                        type="hidden"
                                        name="order_id"
                                        value="<?php
                                        echo $order['order_id'];
                                        ?>"
                                    >


                                    <input
                                        type="hidden"
                                        name="update_status"
                                        value="1"
                                    >



                                    <?php
                                    if ($order['order_status']
                                        == 'Pending') {
                                    ?>


                                        <button
                                            type="submit"
                                            name="status"
                                            value="Cancelled"
                                            class="restaurant-order-cancel-button"
                                        >

                                            Cancel Order

                                        </button>


                                        <button
                                            type="submit"
                                            name="status"
                                            value="Delivering"
                                            class="restaurant-order-deliver-button"
                                        >

                                            Start Delivery

                                            <span>→</span>

                                        </button>


                                    <?php } ?>



                                    <?php
                                    if ($order['order_status']
                                        == 'Delivering') {
                                    ?>


                                        <button
                                            type="submit"
                                            name="status"
                                            value="Cancelled"
                                            class="restaurant-order-cancel-button"
                                        >

                                            Cancel Order

                                        </button>


                                        <span class="restaurant-order-waiting">

                                            Waiting for customer confirmation

                                        </span>


                                    <?php } ?>


                                </form>


                            </div>


                        </article>


                    <?php } ?>


                <?php } else { ?>


                    <!-- EMPTY STATE -->

                    <div class="restaurant-orders-empty">


                        <p class="restaurant-card-label">
                            ORDERS
                        </p>


                        <h2>
                            No active orders
                        </h2>


                        <p>
                            New customer orders will
                            appear here when they are placed.
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