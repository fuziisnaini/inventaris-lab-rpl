<?php
include '../config/database.php';
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); exit; }

$user_id = $_SESSION['user_id'];
// Filter data berdasarkan user login
$query = mysqli_query($conn, "SELECT * FROM barang WHERE user_id=$user_id ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - Inventaris Lab RPL</title>
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
        .nav-link {
            font-weight: 500;
            transition: color 0.2s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: #10b981 !important;
        }
        .main-header {
            padding: 2.5rem 0 1rem 0;
        }
        .table-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
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
            padding: 1.1rem 1rem;
        }
        .table td {
            padding: 1rem;
            vertical-align: middle;
            color: #334155;
            font-size: 0.9rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .table tbody tr:last-child td {
            border-bottom: none;
        }
        .badge-status {
            padding: 0.4rem 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-block;
        }
        .bg-status-baik {
            background-color: #d1fae5;
            color: #065f46;
        }
        .bg-status-rusak {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .bg-status-perbaikan {
            background-color: #fef3c7;
            color: #92400e;
        }
        .btn-action {
            padding: 0.35rem 0.7rem;
            font-size: 0.825rem;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        .btn-add {
            background-color: #2563eb;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        .btn-add:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="#">Inv-Lab <span style="color: #10b981;">RPL.</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link text-white-50" href="../dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active text-white" href="index.php">Data Barang</a></li>
                <li class="nav-item"><a class="nav-link text-white-50" href="../laporan/barang_print.php" target="_blank">Laporan</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="navbar-text text-white-50 me-3 small">Petugas: <strong class="text-white"><?= htmlspecialchars($_SESSION['name']); ?></strong></span>
                <a href="../auth/logout.php" class="btn btn-outline-danger btn-sm px-3" style="border-radius: 6px;">Keluar</a>
            </div>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <div class="main-header d-flex flex-column flex-md-row justify-content-between align-items-md-center">
        <div>
            <h2 class="fw-bold tracking-tight mb-1">Manajemen Aset Barang</h2>
            <p class="text-muted small mb-0">Kelola daftar seluruh inventaris perangkat laboratorium Anda.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="create.php" class="btn btn-add btn-primary px-3 py-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg me-1 align-text-top" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                </svg> Tambah Barang Baru
            </a>
        </div>
    </div>
    
    <div class="card table-card mt-4">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th style="width: 130px;">Kode Barang</th>
                        <th>Nama Perangkat Hardware</th>
                        <th>Kategori</th>
                        <th class="text-center" style="width: 100px;">Jumlah</th>
                        <th>Kondisi</th>
                        <th>Lokasi Penempatan</th>
                        <th>Tgl Input</th>
                        <th class="text-center" style="width: 160px;">Aksi Manajemen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if (mysqli_num_rows($query) > 0):
                        while($row = mysqli_fetch_assoc($query)): 
                    ?>
                    <tr>
                        <td class="text-center text-muted fw-medium"><?= $no++; ?></td>
                        <td class="fw-bold text-secondary" style="font-size: 0.85rem;"><?= htmlspecialchars($row['kode_barang']); ?></td>
                        <td class="fw-semibold text-dark"><?= htmlspecialchars($row['nama_barang']); ?></td>
                        <td><span class="text-muted bg-light px-2 py-1 rounded small" style="border: 1px solid #e2e8f0; font-size: 0.8rem;"><?= htmlspecialchars($row['kategori']); ?></span></td>
                        <td class="text-center fw-bold"><?= number_format($row['jumlah']); ?></td>
                        <td>
                            <?php 
                            $status = $row['kondisi'];
                            if ($status == 'Baik') {
                                echo '<span class="badge-status bg-status-baik">Baik</span>';
                            } elseif ($status == 'Rusak') {
                                echo '<span class="badge-status bg-status-rusak">Rusak</span>';
                            } else {
                                echo '<span class="badge-status bg-status-perbaikan">' . htmlspecialchars($status) . '</span>';
                            }
                            ?>
                        </td>
                        <td class="text-secondary fw-medium"><?= htmlspecialchars($row['lokasi']); ?></td>
                        <td class="text-muted small"><?= date('d/m/Y', strtotime($row['tanggal_input'])); ?></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-action btn-warning text-dark shadow-sm">
                                    Edit
                                </a>
                                <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-action btn-danger text-white shadow-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        endwhile; 
                    else:
                    ?>
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-folder-x text-black-50 mb-2" viewBox="0 0 16 16">
                                <path d="M.5 3A1.5 1.5 0 0 1 2 1.5h5.793a.5.5 0 0 1 .354.146L9.354 2.854a.5.5 0 0 0 .354.146H14A1.5 1.5 0 0 1 15.5 4v9a1.5 1.5 0 0 1-1.5 1.5H2A1.5 1.5 0 0 1 .5 13V3zM2 2.5a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h12a.5.5 0 0 0 .5-.5V4a.5.5 0 0 0-.5-.5H9.707a1.5 1.5 0 0 1-1.06-.44L7.354 1.707A.5.5 0 0 0 7 1.5H2z"/>
                                <path d="M11.854 6.146a.5.5 0 0 0-.708 0L9 8.293 6.854 6.146a.5.5 0 1 0-.708.708L8.293 9l-2.147 2.146a.5.5 0 0 0 .708.708L9 9.707l2.146 2.147a.5.5 0 0 0 .708-.708L9.707 9l2.147-2.146a.5.5 0 0 0 0-.708z"/>
                            </svg>
                            <p class="mb-0 small fw-medium">Belum ada rekaman data barang yang ditambahkan.</p>
                        </td>
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