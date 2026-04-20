<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun - Perpustakaankuu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif;
            background: #f4f7f6; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            margin: 0;
        }
        .card-reg { 
            border: none; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
            width: 100%;
            max-width: 450px; 
            background: #fff;
        }
        .btn-success {
            background: #28a745;
            border: none;
            transition: 0.3s;
        }
        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        .form-control {
            background: #f8f9fa;
            border: 1px solid #eee;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #28a745;
            background: #fff;
        }
    </style>
</head>
<body>

<div class="card card-reg p-4 m-3">
    <div class="text-center mb-4">
        <div class="text-success mb-2" style="font-size: 2rem;">
            <i class="fas fa-user-plus"></i>
        </div>
        <h4 class="font-weight-bold">Registrasi Siswa</h4>
        <p class="text-muted small">Buat akun untuk mulai meminjam buku</p>
    </div>

    <!-- Gunakan base_url + index.php manual agar pasti jalan di XAMPP -->
    <form action="<?= base_url('index.php/auth/register/proses_daftar') ?>" method="post">
        <div class="form-group">
            <label class="small font-weight-bold">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control rounded-pill px-3" placeholder="Nama lengkap Anda" required>
        </div>
        <div class="form-group">
            <label class="small font-weight-bold">Username (Email Sekolah)</label>
            <input type="text" name="username" class="form-control rounded-pill px-3" placeholder="Username untuk login" required>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="small font-weight-bold">Kelas</label>
                    <input type="text" name="kelas" class="form-control rounded-pill px-3" placeholder="Contoh: XII RPL 1" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="small font-weight-bold">Password</label>
                    <input type="password" name="password" class="form-control rounded-pill px-3" placeholder="********" required>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success btn-block rounded-pill shadow-sm mt-3 font-weight-bold">
            Daftar Sekarang
        </button>
    </form>
    
    <div class="text-center mt-4">
        <p class="small mb-1">Sudah punya akun? <a href="<?= base_url('index.php/auth/login') ?>" class="font-weight-bold text-success">Login di sini</a></p>
        <a href="<?= base_url('index.php') ?>" class="small text-muted"><i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda</a>
    </div>
</div>

</body>
</html>