<?php
session_start();
include '../API/config.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = '';
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST['new_username'];

    // Update username di database
    $sql = "UPDATE users SET username = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newUsername, $user_id);

    if ($stmt->execute()) {
        // Perbarui username di sesi setelah diubah
        $_SESSION['username'] = $newUsername;
        
        // Redirect ke dashboard setelah berhasil mengganti username
        header("Location: dashboard.php?success=username_changed");
        exit();
    } else {
        $message = "Gagal mengubah username: " . $stmt->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ganti Username</title>
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

        <form action="ganti_nama.php" method="POST">
            <h2>Ganti Username</h2>
            <div class="form-group">
                <label for="new_username">Username Baru:</label>
                <input type="text" name="new_username" required value="<?php echo $_SESSION['username']; ?>">
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Ganti Username</button>
            </div>

            <?php if (!empty($message)): ?>
                <div class="message <?php echo strpos($message, 'berhasil') !== false ? 'success' : 'error'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
