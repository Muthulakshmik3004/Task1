<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "arts_user_auth");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$successMessage = $errorMessage = "";
$oldPassword = $newPassword = $confirmPassword = "";
$showResetForm = false;

// Handle reset password form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['toggleResetForm'])) {
        $showResetForm = true;
    }

    if (isset($_POST['resetPassword'])) {
        $showResetForm = true;
        $username = $_SESSION['username'];
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        // Fetch user's current password from the database
        $query = "SELECT password FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hashedPassword = $row['password'];

            if (password_verify($oldPassword, $hashedPassword)) {
                if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/', $newPassword)) {
                    if ($newPassword === $confirmPassword) {
                        $hashedNewPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                        $updateQuery = "UPDATE users SET password='$hashedNewPassword' WHERE username='$username'";
                        if (mysqli_query($conn, $updateQuery)) {
                            $successMessage = "Password updated successfully!";
                            $oldPassword = $newPassword = $confirmPassword = "";
                            $showResetForm = false;
                        } else {
                            $errorMessage = "Error updating password. Please try again.";
                        }
                    } else {
                        $errorMessage = "New password and confirmation do not match.";
                    }
                } else {
                    $errorMessage = "Password must be at least 8 characters long, include letters and numbers, and have no spaces.";
                }
            } else {
                $errorMessage = "Old password is incorrect.";
            }
        } else {
            $errorMessage = "User not found.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="profile-container">
        <div class="welcome-message">
            Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
        </div>
        <?php if ($successMessage): ?>
            <div class="success-message"><?php echo $successMessage; ?></div>
        <?php endif; ?>
        <?php if ($errorMessage): ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <?php if (!$showResetForm): ?>
            <button onclick="document.getElementById('toggleResetForm').submit();">Reset Password</button>
            <form id="toggleResetForm" method="POST" style="display: none;">
                <input type="hidden" name="toggleResetForm" value="1">
            </form>
            <a href="home.php" class="home-link">Go to Home</a>
        <?php else: ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="oldPassword">Old Password</label>
                    <input type="password" id="oldPassword" name="oldPassword" value="<?php echo htmlspecialchars($oldPassword); ?>" required>
                </div>
                <div class="form-group">
                    <label for="newPassword">New Password</label>
                    <input type="password" id="newPassword" name="newPassword" value="<?php echo htmlspecialchars($newPassword); ?>" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm New Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" value="<?php echo htmlspecialchars($confirmPassword); ?>" required>
                </div>
                <button type="submit" name="resetPassword">Submit</button>
            </form>
            <a href="home.php" class="home-link">Go to Home</a>
        <?php endif; ?>
    </div>
</body>
</html>
