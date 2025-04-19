<?php
session_start();

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otpInput = $_POST['otp'];

    if (isset($_SESSION['otp']) && $otpInput == $_SESSION['otp']) {
        // Verification successful, redirect to reset password page
        header("Location: reset_password.php");
        exit();
    } else {
        $error_message = "Invalid OTP!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <form action="verify_reset.php" method="POST">
            <h2>Verify OTP</h2>
            <div class="form-group">
                <label for="otp">Enter OTP:</label>
                <input type="text" name="otp" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Verify</button>
            </div>
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
