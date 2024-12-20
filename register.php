<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "arts_user_auth");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Securely hash the password
    $confirmpassword = password_hash($_POST['confirmPassword'], PASSWORD_BCRYPT);

    // Check if the username already exists
    $checkUsername = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $checkUsername);

    if (mysqli_num_rows($result) > 0) {
        $errorMessage = "Username already exists!";
    } else {
        $sql = "INSERT INTO users (username, password,confirmPassword) VALUES ('$username', '$password','$confirmpassword')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Signup successful!'); window.location.href = 'login.php';</script>";
            exit();
        } else {
            $errorMessage = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
  <link rel="stylesheet" href="register.css">
</head>
<body>
  <div class="background">
    <div class="login-container">
      <div class="login-form">        
        <h2>Register</h2>
        <!-- Registration Form -->
        <form id="signupform" method="POST" action="register.php">
          <label for="username">Username:</label>
          <input type="text" id="username" name="username" required>
          <br><br>

          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>
          <br><br>

          <label for="confirmPassword">Confirm Password:</label>
          <input type="password" id="confirmPassword" name="confirmPassword" required>
          <br><br>

          <!-- Register button -->
          <button type="submit" onclick="return validatePasswords()">Register</button>
        </form>

        <!-- Error message container -->
        <p id="errorMessage" style="color:red;">
          <?php if (!empty($errorMessage)) echo $errorMessage; ?>
        </p>
        <div class="login-link">
          <p>Already have an account? <a id="login-btn" href="login.php">Login here</a></p>
        </div>
      </div>
    </div>
  </div>

<script>
  // Validate password matching on the client side
  function validatePasswords() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;
    var errorMessage = document.getElementById("errorMessage");

    // Clear previous error messages
    errorMessage.textContent = "";

    // Check if passwords match
    if (password !== confirmPassword) {
      errorMessage.textContent = "Passwords do not match!";
      return false; // Prevent form submission
    }

    // Check password length
    if (password.length < 8) {
      errorMessage.textContent = "Password must be at least 8 characters long!";
      return false;
    }

    // Check if password contains at least one letter and one number
    var hasLetter = /[a-zA-Z]/.test(password);
    var hasNumber = /[0-9]/.test(password);
    if (!hasLetter || !hasNumber) {
      errorMessage.textContent = "Password must contain at least one letter and one number!";
      return false;
    }

    // Check for whitespaces
    if (/\s/.test(password)) {
      errorMessage.textContent = "Password should not contain whitespace!";
      return false;
    }

    return true; // Allow form submission
  }
</script>

</body>
</html>
