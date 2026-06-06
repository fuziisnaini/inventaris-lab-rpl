<?php
include '../config/database.php';
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - Inventaris Lab RPL</title>
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
        .main-container {
            padding-top: 3rem;
            padding-bottom: 4rem;
        }
        .form-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 10px 15px -3px rgba(0, 0, 0, 0.03);
            background-color: #ffffff;
        }
        .form-header {
            background-color: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.75rem 2rem;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }
        .form-body {
            padding: 2rem;
        }
        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.5rem;
        }
        .form-control, .form-select {
            padding: 0.65rem 1rem;
            border-color: #cbd5e1;
            border-radius: 8px;
            font-size: 0.925rem;
            color: #1e293b;
            transition: all 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }
        .form-control::placeholder {
            color: #94a3b8;
            font-size: 0.9rem;
        }
        .btn-action {
            padding: 0.65rem 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .btn-save {
            background-color: #2563eb;
            border: none;
            color: white;
        }
        .btn-save:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }
        .btn-cancel {
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #475569;
        }
        .btn-cancel:hover {
            background-color: #e2e8f0;
            color: #1e293b;
        }
        .section-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #94a3b8;
            font-weight: 700;
            margin-bottom: 1.25rem;
            border-bottom: 1px dashed #e2e8f0;
            padding-bottom: 0.5rem;
        }
    </style>
</head>
<body>

<div class="container main-container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            
            <div class="mb-3">
                <a href="index.php" class="text-decoration-none small fw-semibold text-secondary d-inline-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-arrow-left me-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg> Kembali ke Daftar Barang
                </a>
            </div>

            <div class="card form-card shadow-sm">
                <div class="form-header d-flex align-items-center">
                    <div class="bg-primary-subtle p-2.5 rounded-3 text-primary me-3" style="background-color: #eff6ff; color: #2563eb; border-radius: 10px; padding: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                            <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.24v7.922l6.5 2.6zM2.5 3.5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Registrasi Aset Baru</h4>
                        <p class="text-muted small mb-0">Tambahkan data logistik ke dalam sistem inventaris laboratorium.</p>
                    </div>
                </div>

                <div class="form-body">
                    <form action="store.php" method="POST">
                        
                        <div class="section-title">A. Identifikasi Perangkat</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Kode Barang</label>
                                <input type="text" name="kode_barang" class="form-control" placeholder="Contoh: PC-001" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Nama Barang / Perangkat</label>
                                <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Monitor LG 24 Inch" required>
                            </div>
                        </div>

                        <div class="section-title">B. Klasifikasi & Volume</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Kategori Komponen</label>
                                <select name="kategori" class="form-select" required>
                                    <option value="" disabled selected hidden>Pilih jenis kategori...</option>
                                    <option value="Komputer">Komputer</option>
                                    <option value="Jaringan">Jaringan</option>
                                    <option value="Multimedia">Multimedia</option>
                                    <option value="Alat Praktik">Alat Praktik</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jumlah / Volume Aset</label>
                                <input type="number" name="jumlah" class="form-control" placeholder="0" min="1" required>
                            </div>
                        </div>

                        <div class="section-title">C. Status Operasional & Penempatan</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Kondisi Fisik</label>
                                <select name="kondisi" class="form-select" required>
                                    <option value="Baik">Baik (Normal)</option>
                                    <option value="Rusak">Rusak (Mati Total)</option>
                                    <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Lokasi Penyimpanan (Rak/Lemari)</label>
                                <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Rak A Lantai 2" required>
                            </div>
                        </div>

                        <div class="section-title">D. Audit Sistem</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Pencatatan</label>
                                <input type="date" name="tanggal_input" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 pt-3 border-top" style="border-top: 1px solid #f1f5f9 !important;">
                            <a href="index.php" class="btn btn-action btn-cancel">Batal</a>
                            <button type="submit" class="btn btn-action btn-save shadow-sm">Simpan Data Aset</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>