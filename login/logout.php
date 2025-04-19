<?php
session_start();
if (isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id']); // Hapus ID pengguna dari session
}
header("Location: index.php");
exit();
?>
