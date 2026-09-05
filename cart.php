<?php

session_start();
require_once('DBconnect.php');

# costomer login check
if (!isset($_SESSION['login_id']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'user') {

    header("Location: index.php");
    exit;
}


$customer_id = $_SESSION['login_id'];
$message = "";

# removing item from cart
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


# applying coupon
if (isset($_POST['apply_coupon'])) {

    $coupon_code = $_POST['coupon_code'];
    $restaurant_id = $_SESSION['cart_restaurant_id'];

    $query = "SELECT * FROM coupons
              WHERE coupon_code = '$coupon_code'
              AND restaurant_id = '$restaurant_id'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {

        $_SESSION['applied_coupon'] =
            mysqli_fetch_assoc($result);

        $message = "Coupon applied successfully!";

    } else {

        $message = "Invalid coupon code.";
    }
}


# order placing
if (isset($_POST['place_order'])) {

    if (isset($_SESSION['cart']) &&
        count($_SESSION['cart']) > 0) {

        $restaurant_id =
            $_SESSION['cart_restaurant_id'];


        $subtotal = 0;

        foreach ($_SESSION['cart'] as $food) {

            $subtotal +=
                $food['price'] * $food['quantity'];
        }

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

        $total_price =
            $subtotal - $discount;

        $query = "INSERT INTO orders
                  (order_datetime,
                   order_status,
                   total_price,
                   restaurant_id,
                   coupon_id)

                  VALUES
                  (NOW(),
                   'Pending',
                   '$total_price',
                   '$restaurant_id',
                   $coupon_id)";

        $result = mysqli_query($conn, $query);


        if ($result) {

            $order_id =
                mysqli_insert_id($conn);

            foreach ($_SESSION['cart'] as $food) {

                $food_id = $food['food_id'];
                $quantity = $food['quantity'];
                $unit_price = $food['price'];

                $query = "INSERT INTO order_items
                          (customer_id,
                           food_id,
                           order_id,
                           quantity,
                           unit_price)

                          VALUES
                          ('$customer_id',
                           '$food_id',
                           '$order_id',
                           '$quantity',
                           '$unit_price')";

                mysqli_query($conn, $query);
            }

            unset($_SESSION['cart']);
            unset($_SESSION['cart_restaurant_id']);
            unset($_SESSION['applied_coupon']);


            header("Location: customer_order.php");
            exit;
        }
    }
}

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Panda Foods - My Cart</title>

    <link rel="stylesheet"
          href="style.css?v=2">

</head>


<body class="cart-page">


    <main class="cart-shell">


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



        <div class="cart-content">


            <!-- =========================
                 HEADER
                 ========================= -->

            <section class="cart-header">

                <div>

                    <p class="browse-page-label">
                        Panda Foods
                    </p>

                    <h1>Your Cart</h1>

                    <p>
                        Review your order before placing it.
                    </p>

                </div>


                <a href="browse_restaurants.php"
                   class="browse-back-button">

                    ← Continue Browsing

                </a>

            </section>



            <?php if ($message != "") { ?>

                <div class="cart-message">

                    <?php
                    echo htmlspecialchars($message);
                    ?>

                </div>

            <?php } ?>



            <?php
            if (isset($_SESSION['cart']) &&
                count($_SESSION['cart']) > 0) {
            ?>


                <?php

                $subtotal = 0;
                $total_items = 0;

                foreach ($_SESSION['cart'] as $food) {

                    $subtotal +=
                        $food['price'] * $food['quantity'];

                    $total_items +=
                        $food['quantity'];
                }

                ?>


                <!-- =========================
                     RECEIPT
                     ========================= -->

                <section class="cart-receipt">


                    <!-- RECEIPT TOP -->

                    <div class="cart-receipt-top">

                        <div>

                            <p>Panda Foods</p>

                            <h2>Order Receipt</h2>

                        </div>


                        <span>
                            <?php echo $total_items; ?>
                            item<?php echo $total_items != 1 ? 's' : ''; ?>
                        </span>

                    </div>



                    <div class="cart-dashed-line"></div>



                    <!-- COLUMN LABELS -->

                    <div class="cart-table-header">

                        <span>Item</span>

                        <span>Price</span>

                        <span>Qty</span>

                        <span>Subtotal</span>

                    </div>



                    <div class="cart-dashed-line"></div>



                    <!-- =========================
                         CART ITEMS
                         ========================= -->

                    <div class="cart-item-list">


                        <?php
                        foreach ($_SESSION['cart'] as $food) {
                        ?>


                            <div class="cart-item-row">


                                <div class="cart-item-name">

                                    <strong>
                                        <?php
                                        echo htmlspecialchars(
                                            $food['food_name']
                                        );
                                        ?>
                                    </strong>


                                    <a href="cart.php?remove=<?php
                                       echo $food['food_id'];
                                       ?>">

                                        Remove

                                    </a>

                                </div>



                                <span>

                                    Tk.
                                    <?php
                                    echo htmlspecialchars(
                                        $food['price']
                                    );
                                    ?>

                                </span>



                                <span>

                                    <?php
                                    echo htmlspecialchars(
                                        $food['quantity']
                                    );
                                    ?>

                                </span>



                                <strong>

                                    Tk.
                                    <?php
                                    echo $food['price']
                                         * $food['quantity'];
                                    ?>

                                </strong>


                            </div>


                        <?php } ?>


                    </div>



                    <div class="cart-dashed-line"></div>



                    <!-- =========================
                         COUPON
                         ========================= -->

                    <div class="cart-coupon-section">


                        <div>

                            <p class="cart-section-label">
                                COUPON
                            </p>

                            <h3>Have a coupon?</h3>

                        </div>



                        <form action="cart.php"
                              method="POST"
                              class="cart-coupon-form">


                            <input
                                type="text"
                                id="coupon_code"
                                name="coupon_code"
                                placeholder="Enter coupon code"
                                required
                            >


                            <button type="submit"
                                    name="apply_coupon">

                                Apply

                            </button>


                        </form>


                    </div>



                    <div class="cart-dashed-line"></div>



                    <!-- =========================
                         ORDER TOTALS
                         ========================= -->

                    <?php

                    $final_total = $subtotal;
                    $discount = 0;

                    if (isset($_SESSION['applied_coupon'])) {

                        $percentage =
                            $_SESSION['applied_coupon']['discount_amount'];

                        $discount =
                            ($subtotal * $percentage) / 100;

                        $final_total =
                            $subtotal - $discount;
                    }

                    ?>


                    <div class="cart-summary">


                        <div class="cart-summary-row">

                            <span>Subtotal</span>

                            <strong>
                                Tk.
                                <?php echo $subtotal; ?>
                            </strong>

                        </div>



                        <?php
                        if (isset($_SESSION['applied_coupon'])) {
                        ?>


                            <div class="cart-summary-row cart-discount-row">

                                <span>

                                    Discount
                                    (<?php echo $percentage; ?>%)

                                </span>

                                <strong>

                                    - Tk.
                                    <?php echo $discount; ?>

                                </strong>

                            </div>


                        <?php } ?>



                        <div class="cart-total-row">

                            <span>Total</span>

                            <strong>

                                Tk.
                                <?php
                                echo max(0, $final_total);
                                ?>

                            </strong>

                        </div>


                    </div>



                    <!-- =========================
                         PLACE ORDER
                         ========================= -->

                    <form action="cart.php"
                          method="POST">

                        <button type="submit"
                                name="place_order"
                                class="cart-place-order-button">

                            Place Order

                            <span>→</span>

                        </button>

                    </form>


                    <p class="cart-receipt-note">

                        Your order will be sent to the restaurant
                        for confirmation after placement.

                    </p>


                </section>


            <?php } else { ?>


                <!-- =========================
                     EMPTY CART
                     ========================= -->

                <section class="cart-empty-state">

                    <p class="browse-page-label">
                        CART
                    </p>

                    <h2>Your cart is empty</h2>

                    <p>
                        Browse restaurants and add something
                        delicious to your cart.
                    </p>

                    <a href="browse_restaurants.php">

                        Browse Restaurants →

                    </a>

                </section>


            <?php } ?>


        </div>


    </main>


</body>

</html>