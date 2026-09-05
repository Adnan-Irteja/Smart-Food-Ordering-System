<?php

session_start();
require_once('DBconnect.php');

# sign out
if (isset($_GET['logout'])) {

    session_unset();
    session_destroy();

    header("Location: index.php");
    exit;
}

# check customer login
if (!isset($_SESSION['login_id']) ||
    $_SESSION['role'] != 'user') {

    header("Location: index.php");
    exit;
}

$login_id = $_SESSION['login_id'];

# get customer info
$query = "SELECT * FROM customers
          WHERE login_id = '$login_id'";

$result = mysqli_query($conn, $query);

$customer = mysqli_fetch_assoc($result);

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Panda Foods - Customer Dashboard</title>

    <link rel="stylesheet" href="style.css?v=2">

</head>


<body class="dashboard-page">


    <main class="dashboard-shell">


        <!-- =========================
             PARTICLES INSIDE WHITE AREA
             ========================= -->

        <div class="dashboard-particles"
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
             DASHBOARD CONTENT
             ========================= -->

        <div class="dashboard-content">


            <!-- =========================
                 LEFT SIDE
                 ========================= -->

            <section class="dashboard-left">


                <!-- WELCOME -->

                <div class="dashboard-welcome">

                    <p class="dashboard-welcome-small">
                        Customer Dashboard
                    </p>

                    <h1>
                        Welcome,
                        <?php echo htmlspecialchars($customer['name']); ?>!
                    </h1>

                    <p>
                        Here's everything you need in one place.
                    </p>

                </div>



                <!-- PROFILE -->

                <div class="dashboard-info-card">

                    <div class="dashboard-card-heading">

                        <p class="dashboard-card-label">
                            PROFILE
                        </p>

                        <h2>Your Profile</h2>

                    </div>


                    <div class="dashboard-info-row">

                        <span>Name</span>

                        <strong>
                            <?php
                            echo htmlspecialchars($customer['name']);
                            ?>
                        </strong>

                    </div>


                    <div class="dashboard-info-row">

                        <span>Username</span>

                        <strong>
                            <?php
                            echo htmlspecialchars($customer['username']);
                            ?>
                        </strong>

                    </div>


                    <div class="dashboard-info-row">

                        <span>Food Preference</span>

                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $customer['foodPreference']
                            );
                            ?>
                        </strong>

                    </div>

                </div>



                <!-- DELIVERY ADDRESS -->

                <div class="dashboard-info-card">

                    <div class="dashboard-card-heading">

                        <p class="dashboard-card-label">
                            DELIVERY
                        </p>

                        <h2>Delivery Address</h2>

                    </div>


                    <div class="dashboard-info-row">

                        <span>House No.</span>

                        <strong>
                            <?php
                            echo htmlspecialchars($customer['house_no']);
                            ?>
                        </strong>

                    </div>


                    <div class="dashboard-info-row">

                        <span>Street</span>

                        <strong>
                            <?php
                            echo htmlspecialchars($customer['street']);
                            ?>
                        </strong>

                    </div>


                    <div class="dashboard-info-row">

                        <span>Area</span>

                        <strong>
                            <?php
                            echo htmlspecialchars($customer['area']);
                            ?>
                        </strong>

                    </div>

                </div>


            </section>



            <!-- =========================
                 RIGHT SIDE
                 ========================= -->

            <section class="dashboard-right">


                <!-- BRANDING -->

                <div class="dashboard-branding">

                    <p class="dashboard-brand-label">
                        Panda Foods
                    </p>

                    <h2>
                        What are you<br>
                        looking for?
                    </h2>

                    <p>
                        Manage your account, find your next meal,
                        and keep track of your orders.
                    </p>

                </div>



                <!-- ACTIONS -->

                <nav class="dashboard-actions">


                    <a class="dashboard-action"
                       href="edit_profile.php">

                        <div>

                            <strong>Edit Profile</strong>

                            <span>
                                Update your details and preferences
                            </span>

                        </div>

                        <span class="dashboard-arrow">→</span>

                    </a>



                    <a class="dashboard-action"
                       href="browse_restaurants.php">

                        <div>

                            <strong>Browse Restaurants</strong>

                            <span>
                                Find restaurants and food
                            </span>

                        </div>

                        <span class="dashboard-arrow">→</span>

                    </a>



                    <a class="dashboard-action"
                       href="customer_order.php">

                        <div>

                            <strong>Check Delivery Status</strong>

                            <span>
                                Track your active orders
                            </span>

                        </div>

                        <span class="dashboard-arrow">→</span>

                    </a>



                    <a class="dashboard-action"
                       href="order_history.php">

                        <div>

                            <strong>Order History</strong>

                            <span>
                                View your previous orders
                            </span>

                        </div>

                        <span class="dashboard-arrow">→</span>

                    </a>



                    <a class="dashboard-action dashboard-signout"
                       href="user_dashboard.php?logout=1">

                        <div>

                            <strong>Sign Out</strong>

                            <span>
                                Return to the login page
                            </span>

                        </div>

                        <span class="dashboard-arrow">→</span>

                    </a>


                </nav>


            </section>


        </div>


    </main>


</body>

</html>