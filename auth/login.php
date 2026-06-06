<?php
include '../config/database.php';

$pesan = "";
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($query) === 1) {
        $user = mysqli_fetch_assoc($query);
        // Verifikasi password hash
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            header("Location: ../dashboard.php");
            exit;
        } else {
            $pesan = "<div class='alert alert-danger shadow-sm border-0 d-flex align-items-center' role='alert'><svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:' fill='currentColor' viewBox='0 0 16 16'><path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/></svg><div>Password yang Anda masukkan salah!</div></div>";
        }
    } else {
        $pesan = "<div class='alert alert-danger shadow-sm border-0 d-flex align-items-center' role='alert'><svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:' fill='currentColor' viewBox='0 0 16 16'><path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/></svg><div>Email tidak terdaftar di sistem!</div></div>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Petugas - Inventaris Lab RPL</title>
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
            background: linear-gradient(135deg, rgba(20, 83, 45, 0.92), rgba(15, 23, 42, 0.95)), 
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
        .login-card {
            max-width: 440px;
            width: 100%;
            margin: 0 auto;
        }
        .form-control {
            padding: 0.75rem 1rem;
            border-color: #e2e8f0;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.12);
        }
        .btn-submit {
            background-color: #16a34a;
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .btn-submit:hover {
            background-color: #15803d;
            transform: translateY(-1px);
        }
        .btn-submit:active {
            transform: translateY(0);
        }
        .brand-logo {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: #16a34a;
            margin-bottom: 2.5rem;
        }
        @media (max-width: 991.98px) {
            body { overflow: auto; height: auto; }
            .split-screen { height: auto; }
            .left-side { padding: 3rem 2rem; text-center: center; height: 300px; }
            .right-side { padding: 3rem 1.5rem; height: auto; }
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0 split-screen">
        
        <div class="col-lg-6 left-side d-none d-lg-flex">
            <div style="max-width: 520px; margin: 0 auto;">
                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill mb-3 fw-semibold">Sistem Manajemen Internal</span>
                <h1 class="display-5 fw-bold mb-3 lh-sm">Pencatatan Inventaris Lab Praktik RPL</h1>
                <p class="text-white-50 lead mb-0 fs-6">Kelola, pantau, dan laporkan kondisi aset digital perangkat keras secara aman, mandiri, dan terstruktur khusus petugas laboratorium.</p>
            </div>
        </div>

        <div class="col-lg-6 right-side">
            <div class="login-card">
                <div class="brand-logo">
                    <span class="text-dark">Inv-Lab</span><span class="text-success">RPL.</span>
                </div>
                
                <h3 class="fw-bold text-dark mb-1">Selamat Datang Kembali</h3>
                <p class="text-muted small mb-4">Silakan masukkan akun petugas Anda untuk mengakses dasbor inventaris.</p>
                
                <?= $pesan; ?>

                <form action="" method="POST" class="mt-2">
                    <div class="mb-3">
                        <label class="form-label small fw-medium text-secondary">Alamat Email</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@contoh.com" required autocomplete="email">
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-medium text-secondary mb-0">Kata Sandi</label>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
                    </div>
                    
                    <button type="submit" name="login" class="btn btn-submit btn-primary w-100 shadow-sm text-white">
                        Masuk Ke Aplikasi
                    </button>
                </form>
                
                <div class="text-center mt-4">
                    <p class="text-muted small mb-0">Belum memiliki akun petugas? <a href="register.php" class="text-success fw-semibold text-decoration-none">Daftar Akun Baru</a></p>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>