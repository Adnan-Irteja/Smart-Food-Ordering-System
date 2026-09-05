<?php

session_start();
require_once('DBconnect.php');

// Check login
if (!isset($_SESSION['login_id']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'restaurant_owner') {

    header("Location: index.php");
    exit;
}


$restaurant_id = $_SESSION['login_id'];

$query = "SELECT coupon_id, coupon_code, discount_amount
          FROM coupons
          WHERE restaurant_id = '$restaurant_id'";

$result = mysqli_query($conn, $query);



?>

<!DOCTYPE html>
<html>

<head>
    <title>My Coupons</title>
</head>

<body>

    <h1>My Coupons</h1>

    <?php if (mysqli_num_rows($result) > 0) { 
        echo "Total Coupons: " . mysqli_num_rows($result);
        ?>

        <?php while ($coupon = mysqli_fetch_assoc($result)) { ?>

            <div>

                <p>
                    <strong>Coupon Code:</strong>
                    <?php echo $coupon['coupon_code']; ?>
                </p>

                <p>
                    <strong>Discount:</strong>
                    <?php echo $coupon['discount_amount']; ?>%
                </p>

                <hr>

            </div>

        <?php } ?>

    <?php } else { ?>

        <p>You currently have no coupons.</p>

    <?php } ?>

    <br>

    <a href="restaurant_dashboard.php">Back to Dashboard</a>

</body>

</html>