<?php
session_start();
require_once('DBconnect.php');

// Make sure the user is logged in and is actually a customer
if (!isset($_SESSION['login_id']) || $_SESSION['role'] != 'user') {
    header("Location: index.php");
    exit;
}

$login_id = $_SESSION['login_id'];

// Get the logged-in customer's information
$query = "SELECT * FROM customers WHERE login_id = '$login_id'";
$result = mysqli_query($conn, $query);

$customer = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
</head>

<body>

    <h1>Welcome <?php echo $customer['name']; ?>!</h1>

    <h2>Your Profile</h2>

    <p>
        <strong>Name:</strong>
        <?php echo $customer['name']; ?>
    </p>

    <p>
        <strong>Username:</strong>
        <?php echo $customer['username']; ?>
    </p>

    <p>
        <strong>Food Preference:</strong>
        <?php echo $customer['foodPreference']; ?>
    </p>

    <h3>Delivery Address</h3>

    <p>
        <strong>House No:</strong>
        <?php echo $customer['house_no']; ?>
    </p>

    <p>
        <strong>Street:</strong>
        <?php echo $customer['street']; ?>
    </p>

    <p>
        <strong>Area:</strong>
        <?php echo $customer['area']; ?>
    </p>

    <br>

    <a href="browse_restaurants.php">Browse Restaurants and Food</a>

    <br><br>

    <a href="edit_profile.php">Edit Profile</a>

    <br><br>

    <a href="customer_order.php">Check Delivery Status</a>

    <br><br>

    <a href="order_history.php">Order History</a>

</body>
</html>