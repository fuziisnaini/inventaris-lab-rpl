<?php
include '../config/database.php';
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id']; // Mengikat ke user login
    $kode_barang = mysqli_real_escape_string($conn, $_POST['kode_barang']);
    $nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $jumlah = intval($_POST['jumlah']);
    $kondisi = mysqli_real_escape_string($conn, $_POST['kondisi']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $tanggal_input = $_POST['tanggal_input'];

    $query = "INSERT INTO barang (user_id, nama_barang, kode_barang, kategori, jumlah, kondisi, lokasi, tanggal_input) 
              VALUES ($user_id, '$nama_barang', '$kode_barang', '$kategori', $jumlah, '$kondisi', '$lokasi', '$tanggal_input')";

    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }
}
?>