<?php
session_start();
include '../API/config.php';
require '../API/vendor/autoload.php'; // Ensure PHPMailer is installed

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Generate OTP and send email
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        // Send OTP via email
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nugra315@gmail.com'; // Your email
        $mail->Password = 'xmxb hxtz daym biru'; // Your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('nugra315@gmail.com', 'Nugra21');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Verivikasi untuk mengganti password ';
        $mail->Body = "Code otp: $otp";

        if ($mail->send()) {
            header("Location: verify_reset.php");
            exit();
        } else {
            $message = "Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        $message = "Email not found!";
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
