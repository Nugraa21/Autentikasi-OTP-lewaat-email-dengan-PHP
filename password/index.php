<?php
session_start();
include '../API/config.php';
require '../API/vendor/autoload.php'; // Pastikan PHPMailer terinstall

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Memeriksa apakah email ada dalam database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Menghasilkan OTP dan mengirim email
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        // Kirim OTP melalui email
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nugra315@gmail.com'; // Email Anda
        $mail->Password = 'xmxb hxtz daym biru'; // Password email Anda
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('nugra315@gmail.com', 'Nugra21');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Verifikasi untuk Mengganti Password';
        $mail->Body = "
            <html>
            <head>
                <style>
                    .email-container {
                        font-family: Arial, sans-serif;
                        color: #333;
                        max-width: 600px;
                        margin: auto;
                        padding: 20px;
                        border: 1px solid #ddd;
                        border-radius: 10px;
                    }
                    .email-header {
                        background-color: #FF5722;
                        padding: 10px;
                        text-align: center;
                        color: white;
                        font-size: 24px;
                        border-radius: 10px 10px 0 0;
                    }
                    .email-body {
                        margin-top: 20px;
                        font-size: 16px;
                    }
                    .otp-code {
                        font-size: 36px;
                        font-weight: bold;
                        color: #FF5722;
                        text-align: center;
                        margin: 20px 0;
                    }
                    .email-footer {
                        margin-top: 20px;
                        font-size: 12px;
                        color: #777;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='email-header'>
                        Permintaan Penggantian Password
                    </div>
                    <div class='email-body'>
                        <p>Hai,</p>
                        <p>Anda telah meminta untuk mengganti password Anda. Berikut adalah kode OTP untuk melanjutkan proses reset password:</p>
                        <div class='otp-code'>$otp</div>
                        <p>Masukkan kode ini di halaman verifikasi untuk melanjutkan. Jika Anda tidak meminta reset password, abaikan email ini.</p>
                    </div>
                    <div class='email-footer'>
                        <p>&copy; 2024 N21.WERE. Semua hak cipta dilindungi.</p>
                    </div>
                </div>
            </body>
            </html>
        ";

        if ($mail->send()) {
            header("Location: verify_reset.php");
            exit();
        } else {
            $message = "Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        $message = "Email tidak ditemukan!";
    }
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password Request</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <form action="index.php" method="POST">
            <h2>Forgot Password</h2>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Send OTP</button>
            </div>
            <?php if (!empty($message)): ?>
                <div class="error-message"><?php echo $message; ?></div>
            <?php endif; ?>
            <div class="text-center">
                <p><a href="../login/index.php">Kembali</a></p>
            </div>
        </form>
    </div>
</body>
</html>
