<?php
include '../config/database.php';

$pesan = "";
if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    // Validasi email duplikat
    $cek_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek_email) > 0) {
        $pesan = "<div class='alert alert-danger shadow-sm border-0 d-flex align-items-center' role='alert'><svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:' fill='currentColor' viewBox='0 0 16 16'><path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/></svg><div>Email sudah terdaftar di sistem!</div></div>";
    } elseif ($password !== $konfirmasi_password) {
        $pesan = "<div class='alert alert-danger shadow-sm border-0 d-flex align-items-center' role='alert'><svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:' fill='currentColor' viewBox='0 0 16 16'><path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/></svg><div>Konfirmasi password tidak cocok!</div></div>";
    } else {
        // Hash password demi keamanan
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
        
        if (mysqli_query($conn, $query)) {
            $pesan = "<div class='alert alert-success shadow-sm border-0 d-flex align-items-center' role='alert'><svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:' fill='currentColor' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/></svg><div>Pendaftaran berhasil! Silakan <a href='login.php' class='alert-link fw-semibold text-decoration-none'>Login di sini</a></div></div>";
        } else {
            $pesan = "<div class='alert alert-danger shadow-sm border-0 d-flex align-items-center' role='alert'><svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:' fill='currentColor' viewBox='0 0 16 16'><path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/></svg><div>Gagal mendaftar. Terjadi kesalahan sistem.</div></div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Petugas - Inventaris Lab RPL</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            overflow: hidden;
        }
        .split-screen {
            height: 100vh;
        }
        .left-side {
            background: linear-gradient(135deg, rgba(29, 78, 216, 0.92), rgba(15, 23, 42, 0.95)), 
                        url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSepXWZTDBC3TlcKzYRzT9vnJMFw95kr82QPA&s') no-repeat center center/cover;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem;
        }
        .right-side {
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem;
            overflow-y: auto;
        }
        .register-card {
            max-width: 440px;
            width: 100%;
            margin: 0 auto;
        }
        .form-control {
            padding: 0.65rem 1rem;
            border-color: #e2e8f0;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }
        .btn-submit {
            background-color: #2563eb;
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .btn-submit:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }
        .btn-submit:active {
            transform: translateY(0);
        }
        .brand-logo {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: #2563eb;
            margin-bottom: 2rem;
        }
        @media (max-width: 991.98px) {
            body { overflow: auto; height: auto; }
            .split-screen { height: auto; }
            .left-side { padding: 3rem 2rem; text-center: center; height: 250px; }
            .right-side { padding: 3rem 1.5rem; height: auto; }
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0 split-screen">
        
        <div class="col-lg-6 left-side d-none d-lg-flex">
            <div style="max-width: 520px; margin: 0 auto;">
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3 fw-semibold">Registrasi Mandiri</span>
                <h1 class="display-5 fw-bold mb-3 lh-sm">Bergabung Sebagai Petugas Laboratorium</h1>
                <p class="text-white-50 lead mb-0 fs-6">Buat akun petugas baru untuk mengelola inventarisasi aset digital, melakukan pelaporan cetak, dan mengamankan rekaman data praktikum secara terintegrasi.</p>
            </div>
        </div>

        <div class="col-lg-6 right-side">
            <div class="register-card">
                <div class="brand-logo">
                    <span class="text-dark">Inv-Lab</span><span class="text-primary">RPL.</span>
                </div>
                
                <h3 class="fw-bold text-dark mb-1">Daftar Akun Petugas</h3>
                <p class="text-muted small mb-4">Lengkapi kolom di bawah ini untuk mendaftarkan hak akses Anda.</p>
                
                <?= $pesan; ?>

                <form action="" method="POST" class="mt-2">
                    <div class="mb-3">
                        <label class="form-label small fw-medium text-secondary mb-1">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" placeholder="Nama Lengkap Anda" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-medium text-secondary mb-1">Alamat Email</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@contoh.com" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-medium text-secondary mb-1">Kata Sandi</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-medium text-secondary mb-1">Konfirmasi Kata Sandi</label>
                        <input type="password" name="konfirmasi_password" class="form-control" placeholder="Ulangi kata sandi Anda" required>
                    </div>
                    
                    <button type="submit" name="register" class="btn btn-submit btn-primary w-100 shadow-sm text-white">
                        Daftarkan Akun Baru
                    </button>
                </form>
                
                <div class="text-center mt-4">
                    <p class="text-muted small mb-0">Sudah memiliki akun petugas? <a href="login.php" class="text-primary fw-semibold text-decoration-none">Login di sini</a></p>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>