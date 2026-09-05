<!DOCTYPE html>
<head>
    <title>User SignUp</title>
</head>
<body>
    <h1>User SignUp</h1>
    <form action="signup.php" method="POST">
        <input type="hidden" name="role" value="user">

        <label for="customername">Name:</label>
        <input type="text" id="customername" name="customername" required>
        <br><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
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

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required>
        <br><br>
        
        <label for="house_no">House No:</label>
        <input type="text" id="house_no" name="house_no" required>
        <br><br>

        <label for="street">Street:</label>
        <input type="text" id="street" name="street" required>
        <br><br>

        <label for="area">Area:</label>
        <input type="text" id="area" name="area" required>
        <br><br>

        <label for="foodpref">Food Preference:</label>

        <select id="foodpref" name="foodpref" required>
            <option value="">-- Select Food Preference --</option>
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