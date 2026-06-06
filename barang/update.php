<?php
include '../config/database.php';
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $user_id = $_SESSION['user_id']; // Validasi kepemilikan via session
    
    $kode_barang = mysqli_real_escape_string($conn, $_POST['kode_barang']);
    $nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $jumlah = intval($_POST['jumlah']);
    $kondisi = mysqli_real_escape_string($conn, $_POST['kondisi']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $tanggal_input = $_POST['tanggal_input'];

    // Update data dengan klausa WHERE ganda (id & user_id)
    $query = "UPDATE barang SET 
                kode_barang='$kode_barang', 
                nama_barang='$nama_barang', 
                kategori='$kategori', 
                jumlah=$jumlah, 
                kondisi='$kondisi', 
                lokasi='$lokasi', 
                tanggal_input='$tanggal_input' 
              WHERE id=$id AND user_id=$user_id";

    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
    } else {
        echo "Gagal memperbarui data.";
    }
}
?>