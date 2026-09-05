<?php

session_start();
require_once('DBconnect.php');

if (!isset($_SESSION['login_id']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'restaurant_owner') {

    header("Location: index.php");
    exit;
}

$restaurant_id = $_SESSION['login_id'];

$message = "";

if (isset($_POST['coupon_code']) &&
    isset($_POST['discount_amount'])) {

    $coupon_code = $_POST['coupon_code'];
    $discount_amount = $_POST['discount_amount'];

    if ($discount_amount > 0 && $discount_amount <= 100) {

        // Check if this restaurant already has the same coupon code
        $check_query = "SELECT * FROM coupons
                        WHERE restaurant_id = '$restaurant_id'
                        AND coupon_code = '$coupon_code'";

        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {

            $message = "You already have a coupon with this code.";

        } else {

            $query = "INSERT INTO coupons
                      (discount_amount, coupon_code, restaurant_id)
                      VALUES
                      ('$discount_amount', '$coupon_code', '$restaurant_id')";

            mysqli_query($conn, $query);

            header("Location: view_res_coupons.php");
            exit;
        }

    } else {

        $message = "Discount amount must be between 1 and 100.";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Coupon</title>
</head>

<body>

    <h1>Add Coupon</h1>

    <?php
    if ($message != "") {
        echo "<p>$message</p>";
    }
    ?>

    <form action="res_coupons.php" method="POST">

        <label for="coupon_code">Coupon Code:</label>
        <input type="text"
               id="coupon_code"
               name="coupon_code"
               required>

        <br><br>

        <label for="discount_amount">Discount Amount (%):</label>
        <input type="number"
               id="discount_amount"
               name="discount_amount"
               min="1"
               max="100"
               required>

        <br><br>

        <button type="submit">Add Coupon</button>

    </form>

    <br>

    <a href="restaurant_dashboard.php">Back to Dashboard</a>

</body>

</html>