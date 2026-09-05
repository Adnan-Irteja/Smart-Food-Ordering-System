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

    <title>Panda Foods - Customer Signup</title>

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
                Your next meal<br>
                starts here.
            </h1>


            <p class="brand-description">

                Create your account, discover restaurants,
                and find food that matches your taste.

            </p>

        </section>



        <!-- =========================
             SIGNUP CARD
             ========================= -->

        <section class="signup-card">


            <div class="signup-card-heading">

                <h2>
                    Create Customer Account
                </h2>

                <p>
                    Join Panda Foods and start ordering.
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
                       value="user">



                <div class="signup-grid">


                    <!-- NAME -->

                    <div class="signup-form-group">

                        <label for="customername">
                            Name
                        </label>

                        <input type="text"
                               id="customername"
                               name="customername"
                               placeholder="Enter your full name"
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
                               placeholder="Enter your email"
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
                               placeholder="Enter your phone number"
                               required>

                    </div>



                    <!-- DATE OF BIRTH -->

                    <div class="signup-form-group">

                        <label for="dob">
                            Date of Birth
                        </label>

                        <input type="date"
                               id="dob"
                               name="dob"
                               required>

                    </div>



                    <!-- HOUSE NUMBER -->

                    <div class="signup-form-group">

                        <label for="house_no">
                            House No.
                        </label>

                        <input type="text"
                               id="house_no"
                               name="house_no"
                               placeholder="Enter house number"
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



                    <!-- FOOD PREFERENCE -->

                    <div class="signup-form-group">

                        <label for="foodpref">
                            Food Preference
                        </label>

                        <select id="foodpref"
                                name="foodpref"
                                required>

                            <option value="">
                                Select Food Preference
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

                    Create Account

                </button>


            </form>



            <!-- =========================
                 LOGIN LINK
                 ========================= -->

            <div class="signup-login-link">

                <p>

                    Already have an account?

                    <a href="index.php">
                        Sign in
                    </a>

                </p>

            </div>


        </section>

    </main>

</body>

</html>