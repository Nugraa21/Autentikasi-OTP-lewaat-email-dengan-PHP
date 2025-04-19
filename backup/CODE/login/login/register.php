<?php
include '../API/config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $username = $_POST['username']; // Ambil username dari form

    // Cek apakah email sudah terdaftar
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = "Email sudah terdaftar!";
    } else {
        // Simpan ke database menggunakan prepared statement
        $stmt = $conn->prepare("INSERT INTO users (email, password, username) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $password, $username); // Tambahkan username

        if ($stmt->execute()) {
            $message = "Pendaftaran berhasil! Silakan login.";
        } else {
            $message = "Error: " . $stmt->error;
        }
    }

    $stmt->close(); // Tutup statement
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar</title>
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
        <form action="register.php" method="POST"> <!-- Ubah action ke register.php -->
            <h2>Daftar</h2>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" required> <!-- Input untuk username -->
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Daftar</button>
            </div>
            <?php if (!empty($message)): ?>
                <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : 'success'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <div class="text-center">
                <p>Sudah punya akun? <a href="../login/index.php">Login di sini</a></p>
            </div>
        </form>
    </div>
</body>
</html>
