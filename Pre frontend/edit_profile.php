<?php
session_start();
require_once('DBconnect.php');

// Make sure the user is logged in and is actually a customer
if (!isset($_SESSION['login_id']) || $_SESSION['role'] != 'user') {
    header("Location: index.php");
    exit;
}

$login_id = $_SESSION['login_id'];

// Get current customer information
$query = "SELECT * FROM customers WHERE login_id = '$login_id'";
$result = mysqli_query($conn, $query);
$customer = mysqli_fetch_assoc($result);

$message = "";


// =========================
// EDIT PROFILE INFORMATION
// =========================
if (isset($_POST['save_profile'])) {

    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $foodPreference = $_POST['foodPreference'];

    // Check whether another account already uses this username
    $username_query = "SELECT * FROM users
                       WHERE username = '$username'
                       AND login_id != '$login_id'";

    $username_result = mysqli_query($conn, $username_query);

    if (mysqli_num_rows($username_result) > 0) {

        $message = "Username is already taken.";

    } else {

        // If password box is empty, keep current password
        if ($password == "") {
            $password = $customer['password'];
        }

        // Update users table
        $query1 = "UPDATE users
                   SET username = '$username',
                       password = '$password'
                   WHERE login_id = '$login_id'";

        mysqli_query($conn, $query1);


        // Update customers table
        $query2 = "UPDATE customers
                   SET name = '$name',
                       username = '$username',
                       password = '$password',
                       email = '$email',
                       phone = '$phone',
                       foodPreference = '$foodPreference'
                   WHERE login_id = '$login_id'";

        mysqli_query($conn, $query2);


        // Keep session username updated
        $_SESSION['username'] = $username;

        $message = "Profile updated successfully.";

        // Reload updated customer data
        $query = "SELECT * FROM customers WHERE login_id = '$login_id'";
        $result = mysqli_query($conn, $query);
        $customer = mysqli_fetch_assoc($result);
    }
}


// =========================
// EDIT DELIVERY ADDRESS
// =========================
if (isset($_POST['save_address'])) {

    $house_no = $_POST['house_no'];
    $street = $_POST['street'];
    $area = $_POST['area'];

    $address_query = "UPDATE customers
                      SET house_no = '$house_no',
                          street = '$street',
                          area = '$area'
                      WHERE login_id = '$login_id'";

    mysqli_query($conn, $address_query);

    $message = "Delivery address updated successfully.";

    // Reload updated customer data
    $query = "SELECT * FROM customers WHERE login_id = '$login_id'";
    $result = mysqli_query($conn, $query);
    $customer = mysqli_fetch_assoc($result);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>

<body>

    <h1>Edit Profile</h1>

    <?php
    if ($message != "") {
        echo "<p>$message</p>";
    }
    ?>


    <!-- PROFILE INFORMATION -->

    <h2>Profile Information</h2>

    <form action="edit_profile.php" method="POST">

        <label for="name">Name:</label>
        <input type="text"
               id="name"
               name="name"
               value="<?php echo $customer['name']; ?>"
               required>

        <br><br>


        <label for="username">Username:</label>
        <input type="text"
               id="username"
               name="username"
               value="<?php echo $customer['username']; ?>"
               required>

        <br><br>


        <label for="password">New Password:</label>
        <input type="password"
               id="password"
               name="password"
               placeholder="Leave blank to keep current password">

        <br><br>


        <label for="email">Email:</label>
        <input type="email"
               id="email"
               name="email"
               value="<?php echo $customer['email']; ?>"
               required>

        <br><br>


        <label for="phone">Phone:</label>
        <input type="text"
               id="phone"
               name="phone"
               value="<?php echo $customer['phone']; ?>"
               required>

        <br><br>


        <label for="foodPreference">Food Preference:</label>

<select id="foodPreference" name="foodPreference" required>

    <option value="Deshi"
        <?php if ($customer['foodPreference'] == 'Deshi') echo 'selected'; ?>>
        Deshi
    </option>

    <option value="Indian"
        <?php if ($customer['foodPreference'] == 'Indian') echo 'selected'; ?>>
        Indian
    </option>

    <option value="Chinese"
        <?php if ($customer['foodPreference'] == 'Chinese') echo 'selected'; ?>>
        Chinese
    </option>

    <option value="Vegan"
        <?php if ($customer['foodPreference'] == 'Vegan') echo 'selected'; ?>>
        Vegan
    </option>

    <option value="Non-Vegan"
        <?php if ($customer['foodPreference'] == 'Non-Vegan') echo 'selected'; ?>>
        Non-Vegan
    </option>

    <option value="Halal"
        <?php if ($customer['foodPreference'] == 'Halal') echo 'selected'; ?>>
        Halal
    </option>

    <option value="Fast Food"
        <?php if ($customer['foodPreference'] == 'Fast Food') echo 'selected'; ?>>
        Fast Food
    </option>

    <option value="Extra Protein"
        <?php if ($customer['foodPreference'] == 'Extra Protein') echo 'selected'; ?>>
        Extra Protein
    </option>

</select>
        <br><br>


        <button type="submit" name="save_profile">
            Save Profile Changes
        </button>

    </form>


    <br><br><br>


    <!-- DELIVERY ADDRESS -->

    <h2>Change Delivery Address</h2>

    <form action="edit_profile.php" method="POST">

        <label for="house_no">House No:</label>
        <input type="text"
               id="house_no"
               name="house_no"
               value="<?php echo $customer['house_no']; ?>"
               required>

        <br><br>


        <label for="street">Street:</label>
        <input type="text"
               id="street"
               name="street"
               value="<?php echo $customer['street']; ?>"
               required>

        <br><br>


        <label for="area">Area:</label>
        <input type="text"
               id="area"
               name="area"
               value="<?php echo $customer['area']; ?>"
               required>

        <br><br>


        <button type="submit" name="save_address">
            Save Delivery Address
        </button>

    </form>


    <br><br>

    <a href="user_dashboard.php">Back to Dashboard</a>

</body>
</html>