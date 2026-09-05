<?php
session_start();
require_once('DBconnect.php');

// Make sure the user is logged in and is actually a RestaurantOwner
if (!isset($_SESSION['login_id']) || $_SESSION['role'] != 'restaurant_owner') {
    header("Location: index.php");
    exit;
}

$login_id = $_SESSION['login_id'];

// Get the logged-in Restaurant's information
$query = "SELECT * FROM restaurants WHERE login_id = '$login_id'";
$result = mysqli_query($conn, $query);

$restaurant = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Restaurant Dashboard</title>
</head>

<body>

    <h1>Welcome to <?php echo $restaurant['restaurant_name']; ?>!</h1>

    <h2>Restaurant Profile</h2>

    <p>
        <strong>Restaurant Name:</strong>
        <?php echo $restaurant['restaurant_name']; ?>
    </p>

    <p>
        <strong>Restaurant Username:</strong>
        <?php echo $restaurant['username']; ?>
    </p>

    <p>
        <strong>Cuisine Type:</strong>
        <?php echo $restaurant['cuisineType']; ?>
    </p>

    <h3>Address</h3>

    <p>
        <strong>City:</strong>
        <?php echo $restaurant['city']; ?>
    </p>

    <p>
        <strong>Street:</strong>
        <?php echo $restaurant['street']; ?>
    </p>

    <p>
        <strong>Area:</strong>
        <?php echo $restaurant['area']; ?>
    </p>

    <br>

    <a href="add_food.php">Add Foods</a>

    <br><br>

    <a href="restaurant_menu.php">Menu</a>

    <br><br>
    
    <a href="res_coupons.php">Add Coupons</a>

    <br><br>

    <a href="view_res_coupons.php">View All Coupons</a>

    <br><br>

    <a href="restaurant_orders.php">View All Orders</a> <!--May Need Changes-->

    <br><br>

    <a href="restaurant_reviews.php">View Reviews</a>


</body>
</html>