<?php

session_start();
require_once('DBconnect.php');

# restaurant login check
if (!isset($_SESSION['login_id']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'restaurant_owner') {

    header("Location: index.php");
    exit;
}

$restaurant_id = $_SESSION['login_id'];
$message = "";
$message_type = "";

# get restaurant info
$restaurant_query = "SELECT restaurant_name
                     FROM restaurants
                     WHERE login_id = '$restaurant_id'";

$restaurant_result =
    mysqli_query($conn, $restaurant_query);

$restaurant =
    mysqli_fetch_assoc($restaurant_result);

# update food item
if (isset($_POST['update_food'])) {

    $food_id = $_POST['food_id'];

    $food_name =
        $_POST['food_name'];

    $food_description =
        $_POST['food_description'];

    $food_tag =
        $_POST['food_tag'];

    $price =
        $_POST['price'];

    $is_available =
        $_POST['is_available'];


    // Calories is optional

    if ($_POST['calories'] == "") {

        $calories = "NULL";

    } else {

        $calories =
            $_POST['calories'];
    }
    if ($price > 0) {

        $update_query = "UPDATE fooditems

                         SET food_name = '$food_name',
                             food_description = '$food_description',
                             food_tag = '$food_tag',
                             price = '$price',
                             is_available = '$is_available',
                             calories = $calories

                         WHERE food_id = '$food_id'
                         AND restaurant_id = '$restaurant_id'";

        mysqli_query(
            $conn,
            $update_query
        );

        $message =
            "Food item updated successfully.";

        $message_type =
            "success";

    } else {

        $message =
            "Price must be greater than 0.";

        $message_type =
            "error";
    }
}

# get restaurant menu items
$query = "SELECT *
          FROM fooditems
          WHERE restaurant_id = '$restaurant_id'
          ORDER BY food_id";

$result = mysqli_query($conn, $query);

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Panda Foods - Restaurant Menu</title>

    <link rel="stylesheet"
          href="style.css?v=3">

</head>


<body class="restaurant-menu-page">


    <main class="restaurant-menu-shell">


        <!-- =========================
             FLOATING PARTICLES
             ========================= -->

        <div class="restaurant-menu-particles"
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



        <div class="restaurant-menu-content">


            <!-- =========================
                 HEADER
                 ========================= -->

            <section class="restaurant-management-header">


                <div>

                    <p class="restaurant-management-label">
                        PANDA FOODS
                    </p>


                    <h1>
                        Restaurant Menu
                    </h1>


                    <p>

                        Manage the food items offered by

                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $restaurant['restaurant_name']
                            );
                            ?>
                        </strong>.

                    </p>

                </div>



                <div class="restaurant-menu-header-actions">


                    <a href="add_food.php"
                       class="restaurant-menu-add-button">

                        ＋ Add Food Item

                    </a>


                    <a href="restaurant_dashboard.php"
                       class="restaurant-management-back">

                        ← Dashboard

                    </a>


                </div>


            </section>



            <!-- =========================
                 MESSAGE
                 ========================= -->

            <?php if ($message != "") { ?>


                <div class="restaurant-menu-message
                    <?php echo $message_type; ?>">

                    <?php
                    echo htmlspecialchars($message);
                    ?>

                </div>


            <?php } ?>



            <!-- =========================
                 MENU HEADING
                 ========================= -->

            <section class="restaurant-menu-summary">


                <div>

                    <p class="restaurant-card-label">
                        MENU ITEMS
                    </p>


                    <h2>
                        Your Current Menu
                    </h2>

                </div>


                <span class="restaurant-menu-count">

                    <?php
                    echo mysqli_num_rows($result);
                    ?>

                    item<?php
                    echo mysqli_num_rows($result) != 1
                        ? 's'
                        : '';
                    ?>

                </span>


            </section>



            <!-- =========================
                 SCROLLABLE FOOD LIST
                 ========================= -->

            <section class="restaurant-menu-list">


                <?php
                if (mysqli_num_rows($result) > 0) {
                ?>


                    <?php
                    while ($food =
                        mysqli_fetch_assoc($result)) {
                    ?>


                        <form
                            action="restaurant_menu.php"
                            method="POST"
                            class="restaurant-menu-item-card"
                        >


                            <input
                                type="hidden"
                                name="food_id"
                                value="<?php
                                echo $food['food_id'];
                                ?>"
                            >



                            <!-- =========================
                                 CARD TOP
                                 ========================= -->

                            <div class="restaurant-menu-item-top">


                                <div>

                                    <p class="restaurant-menu-item-id">

                                        ITEM #
                                        <?php
                                        echo $food['food_id'];
                                        ?>

                                    </p>


                                    <h3>

                                        <?php
                                        echo htmlspecialchars(
                                            $food['food_name']
                                        );
                                        ?>

                                    </h3>

                                </div>



                                <span class="restaurant-menu-availability
                                    <?php
                                    echo $food['is_available'] == 1
                                        ? 'available'
                                        : 'unavailable';
                                    ?>">

                                    <?php

                                    if ($food['is_available'] == 1) {

                                        echo "Available";

                                    } else {

                                        echo "Unavailable";
                                    }

                                    ?>

                                </span>


                            </div>



                            <!-- =========================
                                 EDIT FIELDS
                                 ========================= -->

                            <div class="restaurant-menu-item-grid">


                                <!-- FOOD NAME -->

                                <div class="restaurant-form-group
                                            restaurant-menu-full">


                                    <label
                                        for="food_name_<?php
                                        echo $food['food_id'];
                                        ?>">

                                        Food Name

                                    </label>


                                    <input
                                        type="text"
                                        id="food_name_<?php
                                        echo $food['food_id'];
                                        ?>"
                                        name="food_name"
                                        value="<?php
                                        echo htmlspecialchars(
                                            $food['food_name']
                                        );
                                        ?>"
                                        required
                                    >


                                </div>



                                <!-- DESCRIPTION -->

                                <div class="restaurant-form-group
                                            restaurant-menu-full">


                                    <label
                                        for="food_description_<?php
                                        echo $food['food_id'];
                                        ?>">

                                        Description

                                    </label>


                                    <textarea
                                        id="food_description_<?php
                                        echo $food['food_id'];
                                        ?>"
                                        name="food_description"
                                    ><?php
                                        echo htmlspecialchars(
                                            $food['food_description']
                                        );
                                    ?></textarea>


                                </div>



                                <!-- TAG -->

                                <div class="restaurant-form-group">


                                    <label
                                        for="food_tag_<?php
                                        echo $food['food_id'];
                                        ?>">

                                        Food Tag

                                    </label>


                                    <select
                                        id="food_tag_<?php
                                        echo $food['food_id'];
                                        ?>"
                                        name="food_tag"
                                        required
                                    >


                                        <option value="Deshi"
                                            <?php
                                            if ($food['food_tag']
                                                == 'Deshi')
                                                echo 'selected';
                                            ?>>

                                            Deshi

                                        </option>


                                        <option value="Indian"
                                            <?php
                                            if ($food['food_tag']
                                                == 'Indian')
                                                echo 'selected';
                                            ?>>

                                            Indian

                                        </option>


                                        <option value="Chinese"
                                            <?php
                                            if ($food['food_tag']
                                                == 'Chinese')
                                                echo 'selected';
                                            ?>>

                                            Chinese

                                        </option>


                                        <option value="Vegan"
                                            <?php
                                            if ($food['food_tag']
                                                == 'Vegan')
                                                echo 'selected';
                                            ?>>

                                            Vegan

                                        </option>


                                        <option value="Non-Vegan"
                                            <?php
                                            if ($food['food_tag']
                                                == 'Non-Vegan')
                                                echo 'selected';
                                            ?>>

                                            Non-Vegan

                                        </option>


                                        <option value="Halal"
                                            <?php
                                            if ($food['food_tag']
                                                == 'Halal')
                                                echo 'selected';
                                            ?>>

                                            Halal

                                        </option>


                                        <option value="Fast Food"
                                            <?php
                                            if ($food['food_tag']
                                                == 'Fast Food')
                                                echo 'selected';
                                            ?>>

                                            Fast Food

                                        </option>


                                        <option value="Extra Protein"
                                            <?php
                                            if ($food['food_tag']
                                                == 'Extra Protein')
                                                echo 'selected';
                                            ?>>

                                            Extra Protein

                                        </option>


                                        <option value="Drinks"
                                        <?php
                                        if ($food['food_tag'] == 'Drinks')
                                            echo 'selected';
                                         ?>>

                                            Drinks

                                           </option>


                                    </select>


                                </div>



                                <!-- PRICE -->

                                <div class="restaurant-form-group">


                                    <label
                                        for="price_<?php
                                        echo $food['food_id'];
                                        ?>">

                                        Price

                                    </label>


                                    <div class="restaurant-input-prefix">

                                        <span>Tk.</span>


                                        <input
                                            type="number"
                                            id="price_<?php
                                            echo $food['food_id'];
                                            ?>"
                                            name="price"
                                            value="<?php
                                            echo $food['price'];
                                            ?>"
                                            min="0.01"
                                            step="0.01"
                                            required
                                        >


                                    </div>


                                </div>



                                <!-- CALORIES -->

                                <div class="restaurant-form-group">


                                    <label
                                        for="calories_<?php
                                        echo $food['food_id'];
                                        ?>">

                                        Calories

                                        <span class="restaurant-optional-text">
                                            Optional
                                        </span>

                                    </label>


                                    <input
                                        type="number"
                                        id="calories_<?php
                                        echo $food['food_id'];
                                        ?>"
                                        name="calories"
                                        value="<?php
                                        echo $food['calories'];
                                        ?>"
                                        min="0"
                                    >


                                </div>



                                <!-- AVAILABILITY -->

                                <div class="restaurant-form-group">


                                    <label
                                        for="is_available_<?php
                                        echo $food['food_id'];
                                        ?>">

                                        Availability

                                    </label>


                                    <select
                                        id="is_available_<?php
                                        echo $food['food_id'];
                                        ?>"
                                        name="is_available"
                                        required
                                    >


                                        <option value="1"
                                            <?php
                                            if ($food['is_available']
                                                == 1)
                                                echo 'selected';
                                            ?>>

                                            Available

                                        </option>


                                        <option value="0"
                                            <?php
                                            if ($food['is_available']
                                                == 0)
                                                echo 'selected';
                                            ?>>

                                            Unavailable

                                        </option>


                                    </select>


                                </div>


                            </div>



                            <!-- =========================
                                 SAVE
                                 ========================= -->

                            <div class="restaurant-menu-item-bottom">


                                <div class="restaurant-menu-price-preview">

                                    <span>
                                        Current Price
                                    </span>

                                    <strong>

                                        Tk.
                                        <?php
                                        echo $food['price'];
                                        ?>

                                    </strong>

                                </div>


                                <button
                                    type="submit"
                                    name="update_food"
                                    class="restaurant-menu-save-button"
                                >

                                    Save Changes

                                    <span>✓</span>

                                </button>


                            </div>


                        </form>


                    <?php } ?>


                <?php } else { ?>


                    <!-- =========================
                         EMPTY STATE
                         ========================= -->

                    <div class="restaurant-menu-empty">


                        <p class="restaurant-card-label">
                            MENU
                        </p>


                        <h2>
                            Your menu is empty
                        </h2>


                        <p>
                            Add your first food item
                            to start building your menu.
                        </p>


                        <a href="add_food.php">

                            ＋ Add Food Item

                        </a>


                    </div>


                <?php } ?>


            </section>


        </div>


    </main>


</body>

</html>