<?php
include '../config/database.php';
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); exit; }

$user_id = $_SESSION['user_id'];
$nama_petugas = $_SESSION['name'];

// Mengambil data barang dan total jumlah barang milik user yang login
$query = mysqli_query($conn, "SELECT * FROM barang WHERE user_id=$user_id ORDER BY kode_barang ASC");
$total_jumlah = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah) as total FROM barang WHERE user_id=$user_id"))['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Inventaris Lab</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #1e293b;
            background-color: #ffffff;
        }
        /* Desain Kop Surat Instansi */
        .kop-surat {
            border-bottom: 3px solid #0f172a;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .kop-title {
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #0f172a;
        }
        .kop-subtitle {
            font-size: 0.85rem;
            color: #475569;
            margin-bottom: 0;
        }
        /* Pengaturan Tabel Cetak Profesional */
        .table-laporan {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .table-laporan th {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px;
            border: 1px solid #cbd5e1 !important;
            text-align: center;
        }
        .table-laporan td {
            font-size: 0.85rem;
            padding: 10px;
            border: 1px solid #cbd5e1 !important;
            vertical-align: middle;
        }
        /* Kolom Tanda Tangan Dokumen Resmi */
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: flex-end;
        }
        .signature-box {
            text-align: center;
            width: 250px;
            font-size: 0.9rem;
        }
        .signature-space {
            height: 80px;
        }
        /* Panel Aksi Mengambang (Hanya Muncul di Layar Browser) */
        .action-bar {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 15px 0;
            margin-bottom: 30px;
        }
        /* Aturan Khusus Saat Tombol Cetak Ditekan (Media Print) */
        @media print {
            .no-print { 
                display: none !important; 
            }
            body { 
                padding: 0 !important; 
            }
            .table-laporan th {
                background-color: #f1f5f9 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body class="p-0">

    <div class="action-bar no-print">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <span class="badge bg-primary me-2">Mode Pratinjau Dokumen</span>
                <small class="text-muted">Gunakan tombol di samping untuk mencetak atau menyimpan ke format digital PDF.</small>
            </div>
            <div>
                <a href="../dashboard.php" class="btn btn-outline-secondary btn-sm me-2" style="border-radius: 6px;">
                    &larr; Kembali ke Dashboard
                </a>
                <button onclick="window.print()" class="btn btn-success btn-sm px-3" style="background-color: #16a34a; border: none; border-radius: 6px; font-weight: 500;">
                    Cetak Laporan (Print / PDF)
                </button>
            </div>
        </div>
    </div>

    <div class="container" style="max-width: 960px;">
        
        <div class="kop-surat d-flex align-items-center justify-content-between">
            <div>
                <h1 class="kop-title mb-1">SMK NEGERI INDONESIA</h1>
                <h5 class="fw-semibold text-secondary mb-1" style="font-size: 1rem;">KOMPETENSI KEAHLIAN REKAYASA PERANGKAT LUNAK</h5>
                <p class="kop-subtitle">Jl. Lab Komputer No. 45, Gedung Laboratorium Komputer Terpadu, Lantai 2</p>
            </div>
            <div class="text-end no-print-date">
                <span class="text-muted small">Format: LKS-Internal</span>
            </div>
        </div>

        <div class="text-center mb-4">
            <h4 class="fw-bold text-dark mb-2" style="letter-spacing: -0.5px;">LAPORAN DATA INVENTARIS BARANG LABORATORIUM</h4>
            <p class="text-muted small">Periode Aktif Dokumen Per: <strong><?= date('d F Y'); ?></strong></p>
        </div>

        <div class="row g-0 mb-3 bg-light p-3 rounded border" style="font-size: 0.85rem;">
            <div class="col-6">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <td class="text-muted" style="width: 120px; padding: 2px 0;">Penanggung Jawab</td>
                        <td style="padding: 2px 0;">: <strong><?= htmlspecialchars($nama_petugas); ?></strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted" style="padding: 2px 0;">Status Akses</td>
                        <td style="padding: 2px 0;">: Petugas Laboratorium (RPL)</td>
                    </tr>
                </table>
            </div>
            <div class="col-6 text-md-end d-flex align-items-center justify-content-md-end">
                <div>
                    <span class="text-muted">Tanggal Generate:</span> <?= date('d/m/Y H:i'); ?> WIB
                </div>
            </div>
        </div>

        <table class="table-laporan">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th style="width: 140px;">Kode Barang</th>
                    <th>Nama Komponen Perangkat</th>
                    <th>Kategori</th>
                    <th style="width: 100px;">Kondisi</th>
                    <th>Lokasi Rak</th>
                    <th style="width: 80px;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                if (mysqli_num_rows($query) > 0):
                    while($row = mysqli_fetch_assoc($query)): 
                ?>
                <tr>
                    <td class="text-center text-muted"><?= $no++; ?></td>
                    <td class="fw-mono text-center fw-semibold text-secondary" style="font-size: 0.8rem; font-family: monospace;"><?= htmlspecialchars($row['kode_barang']); ?></td>
                    <td class="fw-medium text-dark"><?= htmlspecialchars($row['nama_barang']); ?></td>
                    <td><?= htmlspecialchars($row['kategori']); ?></td>
                    <td class="text-center">
                        <span class="fw-semibold"><?= htmlspecialchars($row['kondisi']); ?></span>
                    </td>
                    <td><?= htmlspecialchars($row['lokasi']); ?></td>
                    <td class="text-center fw-bold"><?= number_format($row['jumlah']); ?></td>
                </tr>
                <?php 
                    endwhile; 
                else:
                ?>
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted small">Tidak ada rekaman aset barang inventaris atas nama petugas ini.</td>
                </tr>
                <?php endif; ?>
                
                <tr style="background-color: #f8fafc; font-size: 0.9rem;">
                    <td colspan="6" class="text-end fw-bold text-dark" style="padding: 12px 10px;">Total Volume Aset Keseluruhan:</td>
                    <td class="text-center fw-bold text-primary" style="padding: 12px 10px; background-color: #f1f5f9;"><?= number_format($total_jumlah); ?></td>
                </tr>
            </tbody>
        </table>

        <div class="signature-section">
            <div class="signature-box">
                <p class="mb-1 text-muted small">Bandung, <?= date('d F Y'); ?></p>
                <p class="fw-medium mb-0">Petugas Pemeriksa,</p>
                <div class="signature-space"></div>
                <p class="fw-bold text-dark mb-0" style="text-decoration: underline;"><?= htmlspecialchars($nama_petugas); ?></p>
                <p class="text-muted small mb-0" style="font-size: 0.75rem;">NIP. / ID_STAFF: 00<?= $user_id; ?>-RPL</p>
            </div>
        </div>

    </div>

    <script>
        // Memicu perintah print otomatis secara instan saat tab laporan ini diklik oleh Penguji
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>