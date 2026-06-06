<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Jika sudah login, langsung lempar ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
} else {
    // Jika belum login, otomatis arahkan ke halaman login petugas
    header("Location: auth/login.php");
    exit;
}
?>