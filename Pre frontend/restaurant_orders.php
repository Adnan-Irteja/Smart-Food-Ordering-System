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
// UPDATE ORDER STATUS
// =========================

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


// =========================
// GET ACTIVE ORDERS
// =========================

$query = "SELECT *
          FROM orders

          WHERE restaurant_id = '$restaurant_id'

          AND (order_status = 'Pending'
               OR order_status = 'Delivering')

          ORDER BY order_datetime DESC";


$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Restaurant Orders</title>
</head>

<body>

    <h1>Incoming Orders</h1>


    <?php if (mysqli_num_rows($result) > 0) { ?>


        <?php while ($order = mysqli_fetch_assoc($result)) { ?>

            <div>

                <h2>
                    Order #<?php echo $order['order_id']; ?>
                </h2>


                <p>
                    <strong>Date & Time:</strong>
                    <?php echo $order['order_datetime']; ?>
                </p>


                <p>
                    <strong>Status:</strong>
                    <?php echo $order['order_status']; ?>
                </p>


                <p>
                    <strong>Total Amount:</strong>
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

                               WHERE oi.order_id = '$order_id'";


                $item_result = mysqli_query($conn, $item_query);

                ?>


                <?php while ($item = mysqli_fetch_assoc($item_result)) { ?>

                    <p>

                        <?php echo $item['food_name']; ?>

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
                     STATUS BUTTONS
                     ========================= -->

                <form action="restaurant_orders.php" method="POST">

                    <input
                        type="hidden"
                        name="order_id"
                        value="<?php echo $order['order_id']; ?>"
                    >


                    <input
                        type="hidden"
                        name="update_status"
                        value="1"
                    >


                    <?php if ($order['order_status'] == 'Pending') { ?>

                        <button
                            type="submit"
                            name="status"
                            value="Delivering"
                        >
                            Delivering
                        </button>

                    <?php } ?>


                    <?php if ($order['order_status'] == 'Pending') { ?>

                        <button
                            type="submit"
                            name="status"
                            value="Cancelled"
                        >
                            Cancel
                        </button>

                    <?php } ?>


                    <?php if ($order['order_status'] == 'Delivering') { ?>

                        <button
                            type="submit"
                            name="status"
                            value="Cancelled"
                        >
                            Cancel
                        </button>

                    <?php } ?>


                </form>


                <hr>

            </div>

        <?php } ?>


    <?php } else { ?>

        <p>No active orders.</p>

    <?php } ?>


    <br>


    <a href="restaurant_dashboard.php">
        Back to Dashboard
    </a>

</body>

</html>