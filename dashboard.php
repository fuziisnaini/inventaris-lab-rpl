<?php
include 'config/database.php';

// Proteksi Halaman: Jika belum login, tendang ke login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Hitung Ringkasan Data berdasarkan User Login
$total_barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah) as total FROM barang WHERE user_id=$user_id"))['total'] ?? 0;
$kondisi_baik = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah) as total FROM barang WHERE user_id=$user_id AND kondisi='Baik'"))['total'] ?? 0;
$kondisi_rusak = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah) as total FROM barang WHERE user_id=$user_id AND (kondisi='Rusak' OR kondisi='Perlu Perbaikan')"))['total'] ?? 0;

// Ambil 5 data barang terbaru milik petugas login
$barang_terbaru = mysqli_query($conn, "SELECT * FROM barang WHERE user_id=$user_id ORDER BY id DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventaris Lab RPL</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            color: #0f172a;
        }
        .navbar {
            background-color: #0f172a !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .nav-link {
            font-weight: 500;
            transition: color 0.2s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: #10b981 !important;
        }
        .main-header {
            padding: 2.5rem 0 1.5rem 0;
        }
        .stat-card {
            border: none;
            border-radius: 12px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.02);
            background-color: #ffffff;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
        }
        .stat-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .table-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            background-color: #ffffff;
            overflow: hidden;
        }
        .table thead {
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }
        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #64748b;
            padding: 1rem;
        }
        .table td {
            padding: 1rem;
            vertical-align: middle;
            color: #334155;
            font-size: 0.9rem;
        }
        .badge-status {
            padding: 0.4rem 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.75rem;
        }
        .bg-status-baik {
            background-color: #d1fae5;
            color: #065f46;
        }
        .bg-status-rusak {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top py-3">
    <div class="container">
        <a class="navbar-brand text-white" href="#">Inv-Lab <span class="text-emerald" style="color: #10b981;">RPL.</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link active text-white" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white-50" href="barang/index.php">Data Barang</a></li>
                <li class="nav-item"><a class="nav-link text-white-50" href="laporan/barang_print.php" target="_blank">Laporan</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="navbar-text text-white-50 me-3 small">Petugas: <strong class="text-white"><?= htmlspecialchars($_SESSION['name']); ?></strong></span>
                <a href="auth/logout.php" class="btn btn-outline-danger btn-sm px-3" style="border-radius: 6px;">Keluar</a>
            </div>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <div class="main-header d-flex flex-column flex-md-row justify-content-between align-items-md-center">
        <div>
            <h2 class="fw-bold tracking-tight mb-1">Ringkasan Dasbor</h2>
            <p class="text-muted small mb-0">Pantauan metrik global data inventarisasi mandiri Anda.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="barang/create.php" class="btn btn-primary px-3 shadow-sm font-semibold" style="background-color: #2563eb; border: none; border-radius: 8px; font-size: 0.9rem;">
                + Tambah Barang Baru
            </a>
        </div>
    </div>
    
    <div class="row g-3 mt-1">
        <div class="col-md-4">
            <div class="card stat-card p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small fw-medium mb-1">Total Barang Anda</p>
                        <h3 class="fw-bold mb-0"><?= number_format($total_barang); ?> <span class="fs-6 text-muted font-normal">unit</span></h3>
                    </div>
                    <div class="stat-icon-box" style="background-color: #eff6ff; color: #2563eb;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                            <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.24v7.922l6.5 2.6zM2.5 3.5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card stat-card p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small fw-medium mb-1">Kondisi Baik</p>
                        <h3 class="fw-bold mb-0 text-success"><?= number_format($kondisi_baik); ?> <span class="fs-6 text-muted font-normal">unit</span></h3>
                    </div>
                    <div class="stat-icon-box" style="background-color: #ecfdf5; color: #10b981;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card stat-card p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small fw-medium mb-1">Rusak / Perbaikan</p>
                        <h3 class="fw-bold mb-0 text-danger"><?= number_format($kondisi_rusak); ?> <span class="fs-6 text-muted font-normal">unit</span></h3>
                    </div>
                    <div class="stat-icon-box" style="background-color: #fef2f2; color: #ef4444;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                            <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
                            <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card table-card mt-4">
        <div class="card-header border-0 bg-white py-3 px-4 d-flex align-items-center justify-content-between">
            <h5 class="fw-bold mb-0 text-dark" style="font-size: 1.05rem;">5 Riwayat Entry Barang Terbaru</h5>
            <a href="barang/index.php" class="btn btn-link text-decoration-none small p-0 fw-semibold" style="color: #2563eb; font-size: 0.85rem;">Lihat Semua &rarr;</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Perangkat Hardware</th>
                        <th>Kategori</th>
                        <th class="text-center">Jumlah Vol</th>
                        <th>Kondisi Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($barang_terbaru) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($barang_terbaru)): ?>
                        <tr>
                            <td class="fw-semibold text-secondary" style="font-size: 0.85rem;"><?= htmlspecialchars($row['kode_barang']); ?></td>
                            <td class="fw-medium text-dark"><?= htmlspecialchars($row['nama_barang']); ?></td>
                            <td><span class="text-muted bg-light px-2 py-1 rounded" style="font-size: 0.8rem; border: 1px solid #e2e8f0;"><?= htmlspecialchars($row['kategori']); ?></span></td>
                            <td class="text-center fw-semibold"><?= number_format($row['jumlah']); ?></td>
                            <td>
                                <?php if ($row['kondisi'] == 'Baik'): ?>
                                    <span class="badge-status bg-status-baik">Baik</span>
                                <?php else: ?>
                                    <span class="badge-status bg-status-rusak"><?= htmlspecialchars($row['kondisi']); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted small">Belum ada rekaman data inventaris barang yang Anda masukkan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>