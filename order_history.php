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

$customer_id = $_SESSION['login_id'];
# get sort option
$sort = "newest";
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
}
# get status filter
$status_filter = "all";
if (isset($_GET['status'])) {
    $status_filter = $_GET['status'];
}
# build order by sorting
$order_by = "o.order_datetime DESC";

if ($sort == "oldest") {

    $order_by = "o.order_datetime ASC";

} elseif ($sort == "price_high") {

    $order_by = "o.total_price DESC";

} elseif ($sort == "price_low") {

    $order_by = "o.total_price ASC";

} elseif ($sort == "items_high") {

    $order_by = "item_count DESC";

} elseif ($sort == "items_low") {

    $order_by = "item_count ASC";
}
# build status filter condition
$status_condition = "
    AND (
        o.order_status = 'Confirmed'
        OR o.order_status = 'Cancelled'
    )
";

if ($status_filter == "confirmed") {

    $status_condition = "
        AND o.order_status = 'Confirmed'
    ";

} elseif ($status_filter == "cancelled") {

    $status_condition = "
        AND o.order_status = 'Cancelled'
    ";
}

# get customer order history
$query = "SELECT
                 o.order_id,
                 o.order_datetime,
                 o.order_status,
                 o.total_price,
                 o.restaurant_id,
                 r.restaurant_name,
                 SUM(oi.quantity) AS item_count

          FROM orders o

          JOIN order_items oi
          ON o.order_id = oi.order_id

          JOIN restaurants r
          ON o.restaurant_id = r.login_id

          WHERE oi.customer_id = '$customer_id'

          $status_condition

          GROUP BY
              o.order_id,
              o.order_datetime,
              o.order_status,
              o.total_price,
              o.restaurant_id,
              r.restaurant_name

          ORDER BY $order_by";

$result = mysqli_query($conn, $query);

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Panda Foods - Order History</title>

    <link rel="stylesheet"
          href="style.css?v=3">

</head>


<body class="order-history-page">


    <main class="order-history-shell">


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



        <div class="order-history-content">


            <!-- =========================
                 HEADER
                 ========================= -->

            <section class="order-history-header">


                <div>

                    <p class="browse-page-label">
                        Panda Foods
                    </p>

                    <h1>Order History</h1>

                    <p>
                        View your completed and cancelled orders.
                    </p>

                </div>


                <a href="user_dashboard.php"
                   class="browse-back-button">

                    ← Back to Dashboard

                </a>


            </section>



            <!-- =========================
                 FILTER / SORT
                 ========================= -->

            <section class="order-history-filter-card">


                <div>

                    <p class="browse-page-label">
                        HISTORY
                    </p>

                    <h2>
                        Previous Orders
                    </h2>

                </div>



                <form action="order_history.php"
                      method="GET"
                      class="order-history-filter-form">


                    <!-- SORT -->

                    <div class="order-history-filter-field">

                        <label for="sort">
                            Sort By
                        </label>

                        <select id="sort"
                                name="sort">


                            <option value="newest"
                                <?php
                                if ($sort == "newest")
                                    echo "selected";
                                ?>>

                                Newest First

                            </option>


                            <option value="oldest"
                                <?php
                                if ($sort == "oldest")
                                    echo "selected";
                                ?>>

                                Oldest First

                            </option>


                            <option value="price_high"
                                <?php
                                if ($sort == "price_high")
                                    echo "selected";
                                ?>>

                                Price: High to Low

                            </option>


                            <option value="price_low"
                                <?php
                                if ($sort == "price_low")
                                    echo "selected";
                                ?>>

                                Price: Low to High

                            </option>


                            <option value="items_high"
                                <?php
                                if ($sort == "items_high")
                                    echo "selected";
                                ?>>

                                Most Items

                            </option>


                            <option value="items_low"
                                <?php
                                if ($sort == "items_low")
                                    echo "selected";
                                ?>>

                                Fewest Items

                            </option>


                        </select>

                    </div>



                    <!-- STATUS -->

                    <div class="order-history-filter-field">

                        <label for="status">
                            Status
                        </label>

                        <select id="status"
                                name="status">


                            <option value="all"
                                <?php
                                if ($status_filter == "all")
                                    echo "selected";
                                ?>>

                                All Orders

                            </option>


                            <option value="confirmed"
                                <?php
                                if ($status_filter == "confirmed")
                                    echo "selected";
                                ?>>

                                Confirmed

                            </option>


                            <option value="cancelled"
                                <?php
                                if ($status_filter == "cancelled")
                                    echo "selected";
                                ?>>

                                Cancelled

                            </option>


                        </select>

                    </div>



                    <button type="submit"
                            class="order-history-apply-button">

                        Apply

                    </button>


                </form>


            </section>



            <!-- =========================
                 RESULTS HEADING
                 ========================= -->

            <div class="order-history-list-heading">

                <span>
                    <?php
                    echo mysqli_num_rows($result);
                    ?>
                    order<?php
                    echo mysqli_num_rows($result) != 1
                        ? 's'
                        : '';
                    ?>
                    found
                </span>

            </div>



            <!-- =========================
                 ORDER LIST
                 ========================= -->

            <section class="order-history-list">


                <?php
                if (mysqli_num_rows($result) > 0) {
                ?>


                    <?php
                    while ($order =
                        mysqli_fetch_assoc($result)) {
                    ?>


                        <article class="history-order-card">


                            <!-- TOP -->

                            <div class="history-order-top">


                                <div>

                                    <p class="history-order-number">

                                        ORDER #
                                        <?php
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


                                    <p class="history-order-date">

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



                                <span class="history-status
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



                            <!-- ITEMS -->

                            <div class="history-order-items">


                                <p class="history-section-label">
                                    ITEMS
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

                                               WHERE oi.order_id = '$order_id'
                                               AND oi.customer_id = '$customer_id'";


                                $item_result =
                                    mysqli_query(
                                        $conn,
                                        $item_query
                                    );

                                ?>


                                <?php
                                while ($item =
                                    mysqli_fetch_assoc(
                                        $item_result
                                    )) {
                                ?>


                                    <div class="history-item-row">


                                        <span>

                                            <?php
                                            echo htmlspecialchars(
                                                $item['food_name']
                                            );
                                            ?>

                                            ×
                                            <?php
                                            echo $item['quantity'];
                                            ?>

                                        </span>


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

                            <div class="history-order-bottom">


                                <div>

                                    <span>
                                        Total Items
                                    </span>

                                    <strong>
                                        <?php
                                        echo $order['item_count'];
                                        ?>
                                    </strong>

                                </div>


                                <div>

                                    <span>
                                        Total Price
                                    </span>

                                    <strong>
                                        Tk.
                                        <?php
                                        echo $order['total_price'];
                                        ?>
                                    </strong>

                                </div>


                            </div>


                        </article>


                    <?php } ?>


                <?php } else { ?>


                    <div class="order-history-empty">


                        <p class="browse-page-label">
                            HISTORY
                        </p>


                        <h2>
                            No previous orders found
                        </h2>


                        <p>
                            Your confirmed and cancelled
                            orders will appear here.
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