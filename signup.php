<?php

require_once('DBconnect.php');

if (isset($_POST['username']) &&
    isset($_POST['password']) &&
    isset($_POST['role'])) {

    $username = $_POST['username'];
    $pwd = $_POST['password'];
    $role = $_POST['role'];

# check if username is already taken
    $check_query = "SELECT *
                    FROM users
                    WHERE username = '$username'";

    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Customer signup
        if ($role == 'user') {
            header("Location: user_signup.php?error=username_taken");
            exit;
        }
        // Restaurant signup
        else {

            header("Location: restaurant_signup.php?error=username_taken");
            exit;

        }
    }

    # insert login information into users table
    $query = "INSERT INTO users
              (username, password, role)

              VALUES
              ('$username', '$pwd', '$role')";

    mysqli_query($conn, $query);

    // Get ID of newly created user
    $login_id = mysqli_insert_id($conn);

    # customer signup
    if ($role == 'user') {

        $name = $_POST['customername'];

        $email = $_POST['email'];

        $phone = $_POST['phone'];

        $dob = $_POST['dob'];

        $house_no = $_POST['house_no'];

        $street = $_POST['street'];

        $area = $_POST['area'];

        $foodpreference = $_POST['foodpref'];

        $query = "INSERT INTO customers

                  (login_id,
                   name,
                   username,
                   password,
                   email,
                   phone,
                   dob,
                   house_no,
                   street,
                   area,
                   foodPreference)

                  VALUES

                  ('$login_id',
                   '$name',
                   '$username',
                   '$pwd',
                   '$email',
                   '$phone',
                   '$dob',
                   '$house_no',
                   '$street',
                   '$area',
                   '$foodpreference')";


        mysqli_query($conn, $query);

        header("Location: index.php");

        exit;
    }

# restaurant signup
    else {

        $restaurant_name = $_POST['restaurantname'];

        $owner_name = $_POST['ownername'];

        $email = $_POST['email'];

        $phone = $_POST['phone'];

        $city = $_POST['city'];

        $street = $_POST['street'];

        $area = $_POST['area'];

        $permit = $_POST['permit'];

        $cuisine = $_POST['cuisinetype'];

        $query = "INSERT INTO restaurants

                  (login_id,
                   username,
                   password,
                   restaurant_name,
                   ownername,
                   email,
                   phone,
                   city,
                   street,
                   area,
                   permit,
                   cuisineType)

                  VALUES

                  ('$login_id',
                   '$username',
                   '$pwd',
                   '$restaurant_name',
                   '$owner_name',
                   '$email',
                   '$phone',
                   '$city',
                   '$street',
                   '$area',
                   '$permit',
                   '$cuisine')";

        mysqli_query($conn, $query);

        header("Location: index.php");

        exit;
    }
}

?>