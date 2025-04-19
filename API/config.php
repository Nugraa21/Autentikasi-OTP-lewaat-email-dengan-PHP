<?php
$servername = "localhost";
$username = "root"; // Ganti jika menggunakan username berbeda
$password = ""; // Ganti jika menggunakan password
$dbname = "nugra"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
