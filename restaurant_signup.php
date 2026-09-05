<?php

$error = "";

if (isset($_GET['error']) && $_GET['error'] == 'username_taken') {
    $error = "That username is already taken. Please choose another one.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Panda Foods - Restaurant Signup</title>

    <link rel="stylesheet" href="style.css">

</head>


<body class="signup-page">


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

    <main class="signup-shell">


        <!-- =========================
             LEFT SIDE
             ========================= -->

        <section class="signup-branding">

            <p class="brand-label">
                Panda Foods
            </p>


            <h1>
                Bring your food<br>
                to more people.
            </h1>


            <p class="brand-description">

                Register your restaurant, build your menu,
                and start receiving orders from customers.

            </p>

        </section>



        <!-- =========================
             SIGNUP CARD
             ========================= -->

        <section class="signup-card">


            <div class="signup-card-heading">

                <h2>
                    Create Restaurant Account
                </h2>

                <p>
                    Join Panda Foods and start serving customers.
                </p>

            </div>



            <!-- ERROR MESSAGE -->

            <?php if ($error != "") { ?>

                <div class="signup-error">

                    <?php echo $error; ?>

                </div>

            <?php } ?>



            <!-- =========================
                 SIGNUP FORM
                 ========================= -->

            <form action="signup.php"
                  method="POST">


                <input type="hidden"
                       name="role"
                       value="restaurant_owner">



                <div class="signup-grid">


                    <!-- RESTAURANT NAME -->

                    <div class="signup-form-group">

                        <label for="restaurantname">
                            Restaurant Name
                        </label>

                        <input type="text"
                               id="restaurantname"
                               name="restaurantname"
                               placeholder="Enter restaurant name"
                               required>

                    </div>



                    <!-- USERNAME -->

                    <div class="signup-form-group">

                        <label for="username">
                            Username
                        </label>

                        <input type="text"
                               id="username"
                               name="username"
                               placeholder="Choose a username"
                               required>

                    </div>



                    <!-- OWNER NAME -->

                    <div class="signup-form-group">

                        <label for="ownername">
                            Owner Name
                        </label>

                        <input type="text"
                               id="ownername"
                               name="ownername"
                               placeholder="Enter owner name"
                               required>

                    </div>



                    <!-- PASSWORD -->

                    <div class="signup-form-group">

                        <label for="password">
                            Password
                        </label>

                        <input type="password"
                               id="password"
                               name="password"
                               placeholder="Create a password"
                               required>

                    </div>



                    <!-- EMAIL -->

                    <div class="signup-form-group">

                        <label for="email">
                            Email
                        </label>

                        <input type="email"
                               id="email"
                               name="email"
                               placeholder="Enter restaurant email"
                               required>

                    </div>



                    <!-- PHONE -->

                    <div class="signup-form-group">

                        <label for="phone">
                            Phone
                        </label>

                        <input type="text"
                               id="phone"
                               name="phone"
                               placeholder="Enter phone number"
                               required>

                    </div>



                    <!-- STREET -->

                    <div class="signup-form-group">

                        <label for="street">
                            Street
                        </label>

                        <input type="text"
                               id="street"
                               name="street"
                               placeholder="Enter street"
                               required>

                    </div>



                    <!-- AREA -->

                    <div class="signup-form-group">

                        <label for="area">
                            Area
                        </label>

                        <input type="text"
                               id="area"
                               name="area"
                               placeholder="Enter area"
                               required>

                    </div>



                    <!-- CITY -->

                    <div class="signup-form-group">

                        <label for="city">
                            City
                        </label>

                        <input type="text"
                               id="city"
                               name="city"
                               placeholder="Enter city"
                               required>

                    </div>



                    <!-- RESTAURANT PERMIT -->

                    <div class="signup-form-group">

                        <label for="permit">
                            Restaurant Permit
                        </label>

                        <input type="text"
                               id="permit"
                               name="permit"
                               placeholder="Enter permit number"
                               required>

                    </div>



                    <!-- CUISINE TYPE -->

                    <div class="signup-form-group signup-full-width">

                        <label for="cuisinetype">
                            Cuisine Type
                        </label>

                        <select id="cuisinetype"
                                name="cuisinetype"
                                required>

                            <option value="">
                                Select Cuisine Type
                            </option>

                            <option value="Deshi">
                                Deshi
                            </option>

                            <option value="Indian">
                                Indian
                            </option>

                            <option value="Chinese">
                                Chinese
                            </option>

                            <option value="Vegan">
                                Vegan
                            </option>

                            <option value="Non-Vegan">
                                Non-Vegan
                            </option>

                            <option value="Halal">
                                Halal
                            </option>

                            <option value="Fast Food">
                                Fast Food
                            </option>

                            <option value="Extra Protein">
                                Extra Protein
                            </option>

                        </select>

                    </div>

                </div>



                <!-- CREATE ACCOUNT BUTTON -->

                <button type="submit"
                        class="signup-button">

                    Register Restaurant

                </button>


            </form>



            <!-- =========================
                 LOGIN LINK
                 ========================= -->

            <div class="signup-login-link">

                <p>

                    Already registered?

                    <a href="index.php">
                        Sign in
                    </a>

                </p>

            </div>


        </section>

    </main>

</body>

</html>