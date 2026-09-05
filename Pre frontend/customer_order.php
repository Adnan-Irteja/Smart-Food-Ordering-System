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
// CONFIRM ORDER
// =========================

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
    // send customer to the review page
    header("Location: review.php?restaurant_id=$restaurant_id");
    exit;
}


// =========================
// GET CUSTOMER ACTIVE ORDERS
// =========================

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
<html>

<head>

    <title>My Orders</title>

</head>


<body>


    <h1>My Orders</h1>


    <?php if (mysqli_num_rows($result) > 0) { ?>


        <?php while ($order = mysqli_fetch_assoc($result)) { ?>


            <div>


                <h2>
                    Order #<?php echo $order['order_id']; ?>
                </h2>


                <p>
                    <strong>Restaurant:</strong>
                    <?php echo htmlspecialchars($order['restaurant_name']); ?>
                </p>


                <p>
                    <strong>Date & Time:</strong>
                    <?php echo $order['order_datetime']; ?>
                </p>


                <p>
                    <strong>Status:</strong>
                    <?php echo $order['order_status']; ?>
                </p>


                <p>
                    <strong>Total:</strong>
                    Tk. <?php echo $order['total_price']; ?>
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

                $item_result = mysqli_query($conn, $item_query);

                ?>


                <?php while ($item = mysqli_fetch_assoc($item_result)) { ?>


                    <p>

                        <?php echo htmlspecialchars($item['food_name']); ?>

                        x

                        <?php echo $item['quantity']; ?>

                        -

                        Tk.

                        <?php
                        echo $item['unit_price'] * $item['quantity'];
                        ?>

                    </p>


                <?php } ?>


                <!-- =========================
                     CONFIRM RECEIVED
                     ========================= -->

                <?php if ($order['order_status'] == 'Delivering') { ?>


                    <form action="customer_order.php" method="POST">


                        <input
                            type="hidden"
                            name="order_id"
                            value="<?php echo $order['order_id']; ?>"
                        >


                        <input
                            type="hidden"
                            name="restaurant_id"
                            value="<?php echo $order['restaurant_id']; ?>"
                        >


                        <button
                            type="submit"
                            name="confirm_order"
                        >
                            Confirm Received
                        </button>


                    </form>


                <?php } ?>


                <hr>


            </div>


        <?php } ?>


    <?php } else { ?>


        <p>No active orders.</p>


    <?php } ?>


    <br>


    <a href="user_dashboard.php">
        Back to Dashboard
    </a>


</body>

</html>