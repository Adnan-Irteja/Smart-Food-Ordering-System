<?php

session_start();
require_once('DBconnect.php');


// Check customer login

if (!isset($_SESSION['login_id']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'user') {

    header("Location: index.php");
    exit;
}


$customer_id = $_SESSION['login_id'];
$message = "";


// Remove item from cart

if (isset($_GET['remove'])) {

    $remove_id = $_GET['remove'];

    if (isset($_SESSION['cart'][$remove_id])) {
        unset($_SESSION['cart'][$remove_id]);
    }

    if (empty($_SESSION['cart'])) {
        unset($_SESSION['cart']);
        unset($_SESSION['cart_restaurant_id']);
        unset($_SESSION['applied_coupon']);
    }

    header("Location: cart.php");
    exit;
}


// Apply coupon

if (isset($_POST['apply_coupon'])) {

    $coupon_code = $_POST['coupon_code'];
    $restaurant_id = $_SESSION['cart_restaurant_id'];

    $query = "SELECT * FROM coupons
              WHERE coupon_code = '$coupon_code'
              AND restaurant_id = '$restaurant_id'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {

        $_SESSION['applied_coupon'] = mysqli_fetch_assoc($result);

        $message = "Coupon applied successfully!";

    }
    else {

        $message = "Invalid coupon code.";
    }
}


// Place order

if (isset($_POST['place_order'])) {

    if (isset($_SESSION['cart']) &&
        count($_SESSION['cart']) > 0) {

        $restaurant_id = $_SESSION['cart_restaurant_id'];


        // Calculate subtotal

        $subtotal = 0;

        foreach ($_SESSION['cart'] as $food) {
            $subtotal += $food['price'] * $food['quantity'];
        }


        // Calculate discount

        $discount = 0;
        $coupon_id = "NULL";

        if (isset($_SESSION['applied_coupon'])) {

            $discount_percentage =
                $_SESSION['applied_coupon']['discount_amount'];

            $discount =
                ($subtotal * $discount_percentage) / 100;

            $coupon_id =
                $_SESSION['applied_coupon']['coupon_id'];
        }


        // Calculate final price

        $total_price = $subtotal - $discount;


        // Insert order

        $query = "INSERT INTO orders
                  (order_datetime, order_status, total_price,
                   restaurant_id, coupon_id)

                  VALUES
                  (NOW(), 'Pending', '$total_price',
                   '$restaurant_id', $coupon_id)";

        $result = mysqli_query($conn, $query);


        if ($result) {

            $order_id = mysqli_insert_id($conn);


            // Insert order items

            foreach ($_SESSION['cart'] as $food) {

                $food_id = $food['food_id'];
                $quantity = $food['quantity'];
                $unit_price = $food['price'];

                $query = "INSERT INTO order_items
                          (customer_id, food_id, order_id, quantity, unit_price)

                          VALUES
                          ('$customer_id', '$food_id',
                           '$order_id', '$quantity', '$unit_price')";

                mysqli_query($conn, $query);
            }


            // Clear cart

            unset($_SESSION['cart']);
            unset($_SESSION['cart_restaurant_id']);
            unset($_SESSION['applied_coupon']);


            // Go to delivery status

            header("Location: customer_order.php");
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>My Cart</title>
</head>

<body>

    <h1>My Cart</h1>


    <?php if ($message != "") { ?>

        <p>
            <strong><?php echo $message; ?></strong>
        </p>

    <?php } ?>


    <?php if (isset($_SESSION['cart']) &&
              count($_SESSION['cart']) > 0) { ?>


        <?php $subtotal = 0; ?>


        <!-- Cart Items -->

        <?php foreach ($_SESSION['cart'] as $food) { ?>

            <div>

                <h3>
                    <?php echo $food['food_name']; ?>
                </h3>

                <p>
                    <strong>Price:</strong>
                    Tk. <?php echo $food['price']; ?>
                </p>

                <p>
                    <strong>Quantity:</strong>
                    <?php echo $food['quantity']; ?>
                </p>

                <p>
                    <strong>Subtotal:</strong>
                    Tk.
                    <?php echo $food['price'] * $food['quantity']; ?>
                </p>

                <a href="cart.php?remove=<?php echo $food['food_id']; ?>">
                    Remove Item
                </a>

                <hr>

            </div>


            <?php
            $subtotal += $food['price'] * $food['quantity'];
            ?>

        <?php } ?>


        <!-- Coupon -->

        <h3>Apply Coupon</h3>

        <form action="cart.php" method="POST">

            <label for="coupon_code">
                Coupon Code:
            </label>

            <input
                type="text"
                id="coupon_code"
                name="coupon_code"
                required
            >

            <button type="submit" name="apply_coupon">
                Apply
            </button>

        </form>


        <br>


        <!-- Order Summary -->

        <h2>Order Summary</h2>

        <p>
            <strong>Subtotal:</strong>
            Tk. <?php echo $subtotal; ?>
        </p>


        <?php

        $final_total = $subtotal;

        if (isset($_SESSION['applied_coupon'])) {

            $percentage =
                $_SESSION['applied_coupon']['discount_amount'];

            $discount =
                ($subtotal * $percentage) / 100;

            $final_total =
                $subtotal - $discount;

        ?>

            <p>
                <strong>
                    Discount (<?php echo $percentage; ?>%):
                </strong>

                - Tk. <?php echo $discount; ?>
            </p>

        <?php } ?>


        <h3>
            Total:
            Tk. <?php echo max(0, $final_total); ?>
        </h3>


        <!-- Place Order -->

        <form action="cart.php" method="POST">

            <button type="submit" name="place_order">
                Place Order
            </button>

        </form>


    <?php } else { ?>

        <p>Your cart is empty.</p>

    <?php } ?>


    <br>

    <a href="browse_restaurants.php">
        Back to Restaurants
    </a>

</body>

</html>