<?php
session_start();
include '../API/config.php';
require '../API/vendor/autoload.php'; // Pastikan PHPMailer terinstall

$error_message = ''; // Variabel untuk menampung pesan error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Menggunakan prepared statement untuk menghindari SQL Injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Simpan informasi pengguna ke dalam sesi
        $_SESSION['user_id'] = $user['id']; // Simpan ID pengguna
        $_SESSION['username'] = $user['username']; // Simpan username

        // Mengirim OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;

        // Kirim email dengan OTP
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth = true; // Mengaktifkan autentikasi SMTP
        $mail->Username = 'nugra315@gmail.com'; // Email Anda
        $mail->Password = 'xmxb hxtz daym biru'; // Password email Anda
        $mail->SMTPSecure = 'tls'; // Gunakan 'ssl' jika menggunakan port 465
        $mail->Port = 587; // Port untuk TLS

        $mail->setFrom('nugra315@gmail.com', 'Nugra21'); // Format pengirim
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Code OTP N21.WERE';
        $mail->Body = "Kode verifikasi anda adalah: $otp";

        if ($mail->send()) {
            header("Location: verify.php");
            exit();
        } else {
            echo "Pesan tidak dapat dikirim. Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        $error_message = "Email atau password salah!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
        <form action="index.php" method="POST">
            <h2>Login</h2>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Login</button>
            </div>
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <div class="text-center">
                <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
                <p><a href="../password/index.php">Lupa pasword</a></p>
            </div>
        </form>
    </div>
</body>
</html>
