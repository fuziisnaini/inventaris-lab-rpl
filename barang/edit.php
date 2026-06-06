<?php
include '../config/database.php';
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); exit; }

$id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// KEAMANAN: Memastikan data yang dicari sesuai dengan id dan milik user yang sedang login
$query = mysqli_query($conn, "SELECT * FROM barang WHERE id=$id AND user_id=$user_id");

if (mysqli_num_rows($query) === 0) {
    die("
    <!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Akses Ditolak - Inv-Lab RPL</title>
        <link href='https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap' rel='stylesheet'>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f1f5f9; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
            .error-card { background: white; padding: 2.5rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); text-align: center; max-width: 450px; width: 100%; border-top: 4px solid #ef4444; }
        </style>
    </head>
    <body>
        <div class='error-card mx-3'>
            <svg xmlns='http://www.w3.org/2000/svg' width='48' height='48' fill='#ef4444' class='bi bi-shield-slash mb-3' viewBox='0 0 16 16'>
                <path d='M1.093 3.093c-.496c.002-.5.4-.922.9-.922h.014L8 1l5.993 1.171c.5 0 .9.422.9.922v4.06c0 3.308-2.186 6.326-5.46 7.502L8 15l-1.433-.447a11.96 11.96 0 0 1-4.914-5.385L1.093 3.093zM8 2.01L2.007 3.18v4.004c0 2.825 1.834 5.394 4.544 6.425L8 13.91l1.449-.452c2.71-1.03 4.544-3.6 4.544-6.425V3.18L8 2.01z'/>
                <path d='M2.146 2.146a.5.5 0 0 1 .708 0l11 11a.5.5 0 0 1-.708.708l-11-11a.5.5 0 0 1 0-.708z'/>
            </svg>
            <h5 class='fw-bold text-dark mb-2'>Akses Ditolak / Tidak Ditemukan</h5>
            <p class='text-muted small mb-4'>Anda tidak memiliki kewenangan otorisasi untuk mengubah berkas aset inventaris ini.</p>
            <a href='index.php' class='btn btn-sm btn-secondary px-4' style='border-radius: 8px; font-weight:600;'>Kembali ke Daftar</a>
        </div>
    </body>
    </html>
    ");
}

$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - Inventaris Lab RPL</title>
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
            border-color: #d97706;
            box-shadow: 0 0 0 4px rgba(217, 119, 6, 0.12);
        }
        .btn-action {
            padding: 0.65rem 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .btn-update {
            background-color: #d97706;
            border: none;
            color: white;
        }
        .btn-update:hover {
            background-color: #b45309;
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
                    <div class="p-2.5 rounded-3 me-3" style="background-color: #fffbeb; color: #d97706; border-radius: 10px; padding: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25 / .25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Modifikasi Informasi Aset</h4>
                        <p class="text-muted small mb-0">Ubah entri rekaman data logistik penempatan laboratorium rpl.</p>
                    </div>
                </div>

                <div class="form-body">
                    <form action="update.php" method="POST">
                        <input type="hidden" name="id" value="<?= $data['id']; ?>">
                        
                        <div class="section-title">A. Identifikasi Perangkat</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Kode Barang</label>
                                <input type="text" name="kode_barang" class="form-control" value="<?= htmlspecialchars($data['kode_barang']); ?>" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Nama Barang / Perangkat</label>
                                <input type="text" name="nama_barang" class="form-control" value="<?= htmlspecialchars($data['nama_barang']); ?>" required>
                            </div>
                        </div>

                        <div class="section-title">B. Klasifikasi & Volume</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Kategori Komponen</label>
                                <select name="kategori" class="form-select" required>
                                    <option value="Komputer" <?= $data['kategori'] == 'Komputer' ? 'selected' : ''; ?>>Komputer</option>
                                    <option value="Jaringan" <?= $data['kategori'] == 'Jaringan' ? 'selected' : ''; ?>>Jaringan</option>
                                    <option value="Multimedia" <?= $data['kategori'] == 'Multimedia' ? 'selected' : ''; ?>>Multimedia</option>
                                    <option value="Alat Praktik" <?= $data['kategori'] == 'Alat Praktik' ? 'selected' : ''; ?>>Alat Praktik</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jumlah / Volume Aset</label>
                                <input type="number" name="jumlah" class="form-control" value="<?= htmlspecialchars($data['jumlah']); ?>" min="1" required>
                            </div>
                        </div>

                        <div class="section-title">C. Status Operasional & Penempatan</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Kondisi Fisik</label>
                                <select name="kondisi" class="form-select" required>
                                    <option value="Baik" <?= $data['kondisi'] == 'Baik' ? 'selected' : ''; ?>>Baik (Normal)</option>
                                    <option value="Rusak" <?= $data['kondisi'] == 'Rusak' ? 'selected' : ''; ?>>Rusak (Mati Total)</option>
                                    <option value="Perlu Perbaikan" <?= $data['kondisi'] == 'Perlu Perbaikan' ? 'selected' : ''; ?>>Perlu Perbaikan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Lokasi Penyimpanan (Rak/Lemari)</label>
                                <input type="text" name="lokasi" class="form-control" value="<?= htmlspecialchars($data['lokasi']); ?>" required>
                            </div>
                        </div>

                        <div class="section-title">D. Audit Sistem</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Pencatatan</label>
                                <input type="date" name="tanggal_input" class="form-control" value="<?= htmlspecialchars($data['tanggal_input']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 pt-3 border-top" style="border-top: 1px solid #f1f5f9 !important;">
                            <a href="index.php" class="btn btn-action btn-cancel">Batal</a>
                            <button type="submit" class="btn btn-action btn-update shadow-sm">Perbarui Data Aset</button>
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