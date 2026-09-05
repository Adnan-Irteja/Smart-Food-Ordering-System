<!DOCTYPE html>
<html>
<head>
    <title>login</title>
</head>

<body>
    <a href="user_signup.php">User Signup</a>
    <a href="restaurant_signup.php">Restaurant Signup</a>

    <h1>Login</h1>

    <form action="login.php" method="POST">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>

        <p>Login as:</p>

        <div>
            <input type="radio" id="user" name="role" value="user" required>
            <label for="user">User</label>
        </div>

        <div>
            <input type="radio" id="owner" name="role" value="restaurant_owner">
            <label for="owner">Restaurant Owner</label>
        </div>

        <br>

        <button type="submit">Login</button>

    </form>
</body>
</html>