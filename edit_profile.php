<?php

session_start();
require_once('DBconnect.php');

# customer login check
if (!isset($_SESSION['login_id']) ||
    $_SESSION['role'] != 'user') {

    header("Location: index.php");
    exit;
}
$login_id = $_SESSION['login_id'];

# fetching customer data
$query = "SELECT * FROM customers
          WHERE login_id = '$login_id'";

$result = mysqli_query($conn, $query);

$customer = mysqli_fetch_assoc($result);


$message = "";
$message_type = "";

# edit profile
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
        $message_type = "error";

    } else {
        // Keep old password if password box is empty
        if ($password == "") {

            $password = $customer['password'];

        }

        $query1 = "UPDATE users
                   SET username = '$username',
                       password = '$password'
                   WHERE login_id = '$login_id'";

        mysqli_query($conn, $query1);

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
        $message_type = "success";
        // Reload customer data
        $query = "SELECT * FROM customers
                  WHERE login_id = '$login_id'";

        $result = mysqli_query($conn, $query);

        $customer = mysqli_fetch_assoc($result);

    }
}

# edit delivery address
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
    $message_type = "success";
    // Reload customer data
    $query = "SELECT * FROM customers
              WHERE login_id = '$login_id'";

    $result = mysqli_query($conn, $query);

    $customer = mysqli_fetch_assoc($result);

}

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Panda Foods - Edit Profile</title>

    <link rel="stylesheet" href="style.css?v=2">

</head>


<body class="edit-profile-page">


    <!-- =========================
         ANIMATED BACKGROUND
         ========================= -->

    <div class="background-particles"
         aria-hidden="true">


        <!-- LINES -->

        <span class="particle-line line1"></span>
        <span class="particle-line line2"></span>
        <span class="particle-line line3"></span>
        <span class="particle-line line4"></span>
        <span class="particle-line line5"></span>
        <span class="particle-line line6"></span>


        <!-- CIRCLES -->

        <span class="particle circle p1"></span>
        <span class="particle circle p2"></span>
        <span class="particle circle p3"></span>
        <span class="particle circle p4"></span>
        <span class="particle circle p5"></span>


        <!-- OUTLINED CIRCLES -->

        <span class="particle circle-outline p6"></span>
        <span class="particle circle-outline p7"></span>
        <span class="particle circle-outline p8"></span>
        <span class="particle circle-outline p9"></span>


        <!-- SQUARES -->

        <span class="particle square p10"></span>
        <span class="particle square p11"></span>
        <span class="particle square p12"></span>
        <span class="particle square p13"></span>


        <!-- TRIANGLES -->

        <span class="particle triangle p14"></span>
        <span class="particle triangle p15"></span>
        <span class="particle triangle p16"></span>
        <span class="particle triangle p17"></span>


        <!-- DOTS -->

        <span class="particle dot p18"></span>
        <span class="particle dot p19"></span>
        <span class="particle dot p20"></span>
        <span class="particle dot p21"></span>
        <span class="particle dot p22"></span>
        <span class="particle dot p23"></span>


        <!-- DIAMONDS -->

        <span class="particle diamond p24"></span>
        <span class="particle diamond p25"></span>
        <span class="particle diamond p26"></span>

    </div>



    <!-- =========================
         MAIN ORANGE CONTAINER
         ========================= -->

    <main class="edit-profile-shell">


        <!-- =========================
             LEFT BRANDING
             ========================= -->

        <section class="edit-profile-branding">

            <p class="brand-label">
                Panda Foods
            </p>


            <h1>
                Make it<br>
                yours.
            </h1>


            <p class="brand-description">

                Keep your profile, preferences and
                delivery information up to date.

            </p>


            <a href="user_dashboard.php"
               class="edit-profile-back">

                ← Back to Dashboard

            </a>

        </section>



        <!-- =========================
             FORM CARD
             ========================= -->

        <section class="edit-profile-card">


            <div class="edit-profile-card-heading">

                <h2>Edit Profile</h2>

                <p>
                    Update your personal information and delivery address.
                </p>

            </div>



            <!-- =========================
                 MESSAGE
                 ========================= -->

            <?php if ($message != "") { ?>

                <div class="edit-profile-message
                            <?php echo $message_type; ?>">

                    <?php echo htmlspecialchars($message); ?>

                </div>

            <?php } ?>



            <!-- =================================================
                 PROFILE INFORMATION
                 ================================================= -->

            <div class="edit-profile-section-heading">

                <span>PROFILE</span>

                <h3>Profile Information</h3>

            </div>


            <form action="edit_profile.php"
                  method="POST">


                <div class="edit-profile-grid">


                    <!-- NAME -->

                    <div class="edit-profile-form-group">

                        <label for="name">
                            Name
                        </label>

                        <input type="text"
                               id="name"
                               name="name"
                               value="<?php
                               echo htmlspecialchars(
                                   $customer['name']
                               );
                               ?>"
                               required>

                    </div>



                    <!-- USERNAME -->

                    <div class="edit-profile-form-group">

                        <label for="username">
                            Username
                        </label>

                        <input type="text"
                               id="username"
                               name="username"
                               value="<?php
                               echo htmlspecialchars(
                                   $customer['username']
                               );
                               ?>"
                               required>

                    </div>



                    <!-- EMAIL -->

                    <div class="edit-profile-form-group">

                        <label for="email">
                            Email
                        </label>

                        <input type="email"
                               id="email"
                               name="email"
                               value="<?php
                               echo htmlspecialchars(
                                   $customer['email']
                               );
                               ?>"
                               required>

                    </div>



                    <!-- PHONE -->

                    <div class="edit-profile-form-group">

                        <label for="phone">
                            Phone
                        </label>

                        <input type="text"
                               id="phone"
                               name="phone"
                               value="<?php
                               echo htmlspecialchars(
                                   $customer['phone']
                               );
                               ?>"
                               required>

                    </div>



                    <!-- PASSWORD -->

                    <div class="edit-profile-form-group">

                        <label for="password">
                            New Password
                        </label>

                        <input type="password"
                               id="password"
                               name="password"
                               placeholder="Leave blank to keep current password">

                    </div>



                    <!-- FOOD PREFERENCE -->

                    <div class="edit-profile-form-group">

                        <label for="foodPreference">
                            Food Preference
                        </label>


                        <select id="foodPreference"
                                name="foodPreference"
                                required>


                            <option value="Deshi"
                                <?php
                                if ($customer['foodPreference'] == 'Deshi')
                                    echo 'selected';
                                ?>>

                                Deshi

                            </option>


                            <option value="Indian"
                                <?php
                                if ($customer['foodPreference'] == 'Indian')
                                    echo 'selected';
                                ?>>

                                Indian

                            </option>


                            <option value="Chinese"
                                <?php
                                if ($customer['foodPreference'] == 'Chinese')
                                    echo 'selected';
                                ?>>

                                Chinese

                            </option>


                            <option value="Vegan"
                                <?php
                                if ($customer['foodPreference'] == 'Vegan')
                                    echo 'selected';
                                ?>>

                                Vegan

                            </option>


                            <option value="Non-Vegan"
                                <?php
                                if ($customer['foodPreference'] == 'Non-Vegan')
                                    echo 'selected';
                                ?>>

                                Non-Vegan

                            </option>


                            <option value="Halal"
                                <?php
                                if ($customer['foodPreference'] == 'Halal')
                                    echo 'selected';
                                ?>>

                                Halal

                            </option>


                            <option value="Fast Food"
                                <?php
                                if ($customer['foodPreference'] == 'Fast Food')
                                    echo 'selected';
                                ?>>

                                Fast Food

                            </option>


                            <option value="Extra Protein"
                                <?php
                                if ($customer['foodPreference'] == 'Extra Protein')
                                    echo 'selected';
                                ?>>

                                Extra Protein

                            </option>


                        </select>

                    </div>


                </div>



                <button type="submit"
                        name="save_profile"
                        class="edit-profile-button">

                    Save Profile Changes

                </button>


            </form>



            <!-- =================================================
                 DIVIDER
                 ================================================= -->

            <div class="edit-profile-divider"></div>



            <!-- =================================================
                 DELIVERY ADDRESS
                 ================================================= -->

            <div class="edit-profile-section-heading">

                <span>DELIVERY</span>

                <h3>Delivery Address</h3>

            </div>


            <form action="edit_profile.php"
                  method="POST">


                <div class="edit-profile-address-grid">


                    <!-- HOUSE NUMBER -->

                    <div class="edit-profile-form-group">

                        <label for="house_no">
                            House No.
                        </label>

                        <input type="text"
                               id="house_no"
                               name="house_no"
                               value="<?php
                               echo htmlspecialchars(
                                   $customer['house_no']
                               );
                               ?>"
                               required>

                    </div>



                    <!-- STREET -->

                    <div class="edit-profile-form-group">

                        <label for="street">
                            Street
                        </label>

                        <input type="text"
                               id="street"
                               name="street"
                               value="<?php
                               echo htmlspecialchars(
                                   $customer['street']
                               );
                               ?>"
                               required>

                    </div>



                    <!-- AREA -->

                    <div class="edit-profile-form-group">

                        <label for="area">
                            Area
                        </label>

                        <input type="text"
                               id="area"
                               name="area"
                               value="<?php
                               echo htmlspecialchars(
                                   $customer['area']
                               );
                               ?>"
                               required>

                    </div>


                </div>



                <button type="submit"
                        name="save_address"
                        class="edit-profile-button
                               edit-profile-address-button">

                    Save Delivery Address

                </button>


            </form>



            <!-- MOBILE BACK LINK -->

            <div class="edit-profile-mobile-back">

                <a href="user_dashboard.php">

                    ← Back to Dashboard

                </a>

            </div>


        </section>


    </main>


</body>

</html>