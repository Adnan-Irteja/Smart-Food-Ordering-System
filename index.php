<?php
$error = "";

if (isset($_GET['error']) && $_GET['error'] == 'invalid_login') {
    $error = "Incorrect username, password, or account type.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Panda Foods - Login</title>

    <link rel="stylesheet" href="style.css">
</head>

<body class="login-page">

    <div class="background-particles" aria-hidden="true">

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

    <main class="login-shell">

        <!-- LEFT SIDE -->

        <section class="login-branding">

            <p class="brand-label">Panda Foods</p>

            <h1>
                Good food,<br>
                made easy.
            </h1>

            <p class="brand-description">
                Discover restaurants, find food you love,
                and place your order in just a few steps.
            </p>

        </section>


        <!-- LOGIN CARD -->

        <section class="login-card">

            <div class="login-card-heading">

                <h2>Welcome back</h2>

                <p>
                    Choose your account type and sign in.
                </p>

            </div>


            <?php if ($error != "") { ?>

                <div class="login-error">
                    <?php echo $error; ?>
                </div>

            <?php } ?>


            <form action="login.php" method="POST">

                <!-- ACCOUNT TYPE -->

                <div class="role-switch">

                    <input type="radio"
                           id="user"
                           name="role"
                           value="user"
                           checked
                           required>

                    <label for="user">
                        Customer
                    </label>


                    <input type="radio"
                           id="owner"
                           name="role"
                           value="restaurant_owner">

                    <label for="owner">
                        Restaurant
                    </label>

                </div>


                <!-- USERNAME -->

                <div class="form-group">

                    <label for="username">
                        Username
                    </label>

                    <input type="text"
                           id="username"
                           name="username"
                           placeholder="Enter your username"
                           required>

                </div>


                <!-- PASSWORD -->

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="Enter your password"
                           required>

                </div>


                <button class="primary-button"
                        type="submit">

                    Sign In

                </button>

            </form>


            <!-- SIGNUP LINKS -->

            <div class="signup-section">

                <p>
                    New customer?
                    <a href="user_signup.php">
                        Create an account
                    </a>
                </p>

                <p>
                    Own a restaurant?
                    <a href="restaurant_signup.php">
                        Register here
                    </a>
                </p>

            </div>

        </section>

    </main>

</body>
</html>