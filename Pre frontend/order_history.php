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
// GET SORT OPTION
// =========================

$sort = "newest";

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
}


// =========================
// GET STATUS FILTER
// =========================

$status_filter = "all";

if (isset($_GET['status'])) {
    $status_filter = $_GET['status'];
}


// =========================
// BUILD ORDER BY
// =========================

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


// =========================
// BUILD STATUS CONDITION
// =========================

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


// =========================
// GET ORDER HISTORY
// =========================

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
<html>

<head>

    <title>Order History</title>

</head>


<body>


    <h1>Order History</h1>


    <!-- =========================
         SORT AND FILTER
         ========================= -->

    <form action="order_history.php" method="GET">


        <!-- SORT -->

        <label for="sort">
            Sort By:
        </label>

        <select id="sort" name="sort">


            <option value="newest"
                <?php if ($sort == "newest") echo "selected"; ?>>

                Newest First

            </option>


            <option value="oldest"
                <?php if ($sort == "oldest") echo "selected"; ?>>

                Oldest First

            </option>


            <option value="price_high"
                <?php if ($sort == "price_high") echo "selected"; ?>>

                Price: High to Low

            </option>


            <option value="price_low"
                <?php if ($sort == "price_low") echo "selected"; ?>>

                Price: Low to High

            </option>


            <option value="items_high"
                <?php if ($sort == "items_high") echo "selected"; ?>>

                Most Items

            </option>


            <option value="items_low"
                <?php if ($sort == "items_low") echo "selected"; ?>>

                Fewest Items

            </option>


        </select>


        &nbsp;&nbsp;


        <!-- STATUS FILTER -->

        <label for="status">
            Status:
        </label>


        <select id="status" name="status">


            <option value="all"
                <?php if ($status_filter == "all") echo "selected"; ?>>

                All Orders

            </option>


            <option value="confirmed"
                <?php if ($status_filter == "confirmed") echo "selected"; ?>>

                Confirmed

            </option>


            <option value="cancelled"
                <?php if ($status_filter == "cancelled") echo "selected"; ?>>

                Cancelled

            </option>


        </select>


        <button type="submit">
            Apply
        </button>


    </form>


    <br><br>


    <!-- =========================
         ORDER LIST
         ========================= -->

    <?php if (mysqli_num_rows($result) > 0) { ?>


        <?php while ($order = mysqli_fetch_assoc($result)) { ?>


            <div>


                <h2>
                    Order #<?php echo $order['order_id']; ?>
                </h2>


                <p>

                    <strong>Restaurant:</strong>

                    <?php
                    echo htmlspecialchars(
                        $order['restaurant_name']
                    );
                    ?>

                </p>


                <p>

                    <strong>Date & Time:</strong>

                    <?php
                    echo $order['order_datetime'];
                    ?>

                </p>


                <p>

                    <strong>Status:</strong>

                    <?php
                    echo $order['order_status'];
                    ?>

                </p>


                <!-- =========================
                     ORDER ITEMS
                     ========================= -->

                <h3>Items Ordered</h3>


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


                <?php while ($item = mysqli_fetch_assoc($item_result)) { ?>


                    <p>

                        <?php
                        echo htmlspecialchars(
                            $item['food_name']
                        );
                        ?>

                        x

                        <?php
                        echo $item['quantity'];
                        ?>

                        -

                        Tk.

                        <?php
                        echo $item['unit_price']
                             * $item['quantity'];
                        ?>

                    </p>


                <?php } ?>


                <!-- =========================
                     ORDER SUMMARY
                     ========================= -->

                <p>

                    <strong>Total Items:</strong>

                    <?php
                    echo $order['item_count'];
                    ?>

                </p>


                <p>

                    <strong>Total Price:</strong>

                    Tk.

                    <?php
                    echo $order['total_price'];
                    ?>

                </p>


                <hr>


            </div>


        <?php } ?>


    <?php } else { ?>


        <p>No previous orders found.</p>


    <?php } ?>


    <br>


    <a href="user_dashboard.php">
        Back to Dashboard
    </a>


</body>

</html>