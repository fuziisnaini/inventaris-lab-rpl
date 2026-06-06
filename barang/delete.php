<?php
include '../config/database.php';
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); exit; }

$id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Hapus data hanya jika ID barang tersebut benar-benar milik User yang sedang login
$query = "DELETE FROM barang WHERE id=$id AND user_id=$user_id";

if (mysqli_query($conn, $query)) {
    if (mysqli_affected_rows($conn) > 0) {
        header("Location: index.php");
    } else {
        die("<div style='color:red; text-align:center; margin-top:50px;'><h3>Data tidak ditemukan atau Anda tidak memiliki akses!</h3><a href='index.php'>Kembali</a></div>");
    }
} else {
    echo "Gagal menghapus data.";
}
?>