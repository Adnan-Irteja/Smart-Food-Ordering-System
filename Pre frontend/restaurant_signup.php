<!DOCTYPE html>
<head>
    <title>Restaurant SignUp</title>
</head>
<body>
    <h1>Restaurant SignUp</h1>
    <form action="signup.php" method="POST">
        <input type="hidden" name="role" value="restaurant_owner" required>

        <label for="restaurantname">Restaurant Name:</label>
        <input type="text" id="restaurantname" name="restaurantname" required>
        <br><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br><br>

        <label for="ownername">Owner name:</label>
        <input type="text" id="ownername" name="ownername" required>
        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>
        <br><br>

        <label for="street">Street:</label>
        <input type="text" id="street" name="street" required>
        <br><br>

        <label for="area">Area:</label>
        <input type="text" id="area" name="area" required>
        <br><br>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" required>
        <br><br>

        <label for="permit">Restaurant Permit:</label>
        <input type="text" id="permit" name="permit" required>
        <br><br>

        <label for="cuisinetype">Cuisine Type:</label>

        <select id="cuisinetype" name="cuisinetype" required>
        <option value="">-- Select Cuisine --</option>
        <option value="Deshi">Deshi</option>
        <option value="Indian">Indian</option>
        <option value="Chinese">Chinese</option>
        <option value="Vegan">Vegan</option>
        <option value="Non-Vegan">Non-Vegan</option>
        <option value="Halal">Halal</option>
        <option value="Fast Food">Fast Food</option>
        <option value="Extra Protein">Extra Protein</option>
        </select>

        <button type="submit">Create Account</button>
    </form>
</body>
</html>