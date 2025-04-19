<?php
session_start();
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otpInput = $_POST['otp'];

    if (isset($_SESSION['otp']) && $otpInput == $_SESSION['otp']) {
        // Verifikasi berhasil
        unset($_SESSION['otp']); // Hapus OTP dari sesi setelah verifikasi berhasil
        header("Location: dashboard.php"); // Redirect ke dashboard
        exit();
    } else {
        $error_message = "OTP tidak valid!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi OTP</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" href="../assets/media/icon.png">
</head>
<body>
    <div class="container">
        <div class="login-logo">
            <div>
                <img width="50px" height="50px" src="../assets/media/icon.png" alt="">
            </div>
            <div>
                <b>Nugra </b>DEV
            </div>
        </div>
        <form action="verify.php" method="POST">
            <h2>Verifikasi OTP</h2>
            <div class="form-group">
                <label for="otp">Masukkan OTP:</label>
                <input type="text" name="otp" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Verifikasi</button>
            </div>
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
