<?php
session_start();
include '../API/config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $email = $_SESSION['email']; // Get email from session

    // Update the password in the database
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $newPassword, $email);

    if ($stmt->execute()) {
        $message = "Password reset successfully!";
        unset($_SESSION['otp']); // Clear OTP
        unset($_SESSION['email']); // Clear email
    } else {
        $message = "Error: " . $stmt->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <form action="reset_password.php" method="POST">
            <h2>Reset Password</h2>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Reset Password</button>
            </div>
            <?php if (!empty($message)): ?>
                <div class="success-message"><?php echo $message; ?></div>
                <?php if ($message === "Password reset successfully!"): ?>
                    <div class="login-link">
                        <a href="../login/index.php">Kembali ke Halaman Login</a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
