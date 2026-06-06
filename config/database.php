<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "inventaris_lab";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Memulai session secara global jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>