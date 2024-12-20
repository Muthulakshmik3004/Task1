<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "arts_user_auth");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user from the database
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['username'] = $user['username'];

            // Redirect to the home page
            header("Location: home.php");
            exit();
        } else {
            $error = "Invalid username or password!";
        }
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="background">
        <div class="login-container">
            <div class="login-form">
                <h1>Digital Art</h1>
                <h2>Login</h2>
                <form id="loginForm" method="POST" action="login.php">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                    
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <button type="submit">Login</button>
                    
                    <p>Don't have an account? <a class="register-btn" href="register.php">register</a></p>
                </form>

                <!-- Display error message -->
                <?php if (!empty($error)): ?>
                    <p id="errorMessage" style="color:red;"><?php echo $error; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
