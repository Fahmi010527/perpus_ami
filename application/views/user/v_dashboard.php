<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul; ?> | Perpustakaankuu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7f6; overflow-x: hidden; }
        #sidebar { min-width: 250px; max-width: 250px; min-height: 100vh; background: #fff; transition: all 0.3s; border-right: 1px solid #eee; }
        .sidebar-header { padding: 20px; text-align: center; border-bottom: 1px solid #f8f9fa; }
        ul.components { padding: 20px 0; }
        ul li a { color: #555; text-decoration: none; display: block; padding: 12px 15px; border-radius: 10px; margin: 0 20px; transition: 0.3s; font-weight: 500; }
        ul li a:hover, ul li.active a { background: #eef5ff; color: #007bff; }
        #content { width: 100%; padding: 30px; }
        .user-card { background: linear-gradient(135deg, #007bff, #0056b3); color: white; border-radius: 20px; padding: 30px; margin-bottom: 30px; }
        
        /* UPDATE: Efek Gerak & Pointer */
        .stat-card { 
            background: #fff; 
            border: none; 
            border-radius: 15px; 
            padding: 20px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.02); 
            transition: all 0.3s ease; /* Efek transisi halus */
            cursor: pointer;
            display: block; /* Supaya link membungkus sempurna */
            text-decoration: none !important; /* Menghilangkan garis bawah link */
            color: inherit;
        }

        /* Efek saat kursor di atas kartu */
        .stat-card:hover { 
            transform: translateY(-10px); /* Bergerak ke atas */
            box-shadow: 0 12px 20px rgba(0,0,0,0.08); /* Bayangan lebih dalam */
        }

        .icon-box { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 15px; }
        .img-cover { width: 45px; height: 65px; object-fit: cover; border-radius: 5px; }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- SIDEBAR -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h6 class="font-weight-bold mb-0"><i class="fas fa-book-reader text-primary"></i> Perpustakaankuu</h6>
        </div>
        <ul class="list-unstyled components">
            <li class="<?= $this->uri->segment(2) == '' ? 'active' : '' ?>">
                <a href="<?= base_url('index.php/user') ?>"><i class="fas fa-home"></i> Dashboard</a>
            </li>
            <li class="<?= $this->uri->segment(2) == 'cari_buku' ? 'active' : '' ?>">
                <a href="<?= base_url('index.php/user/cari_buku') ?>"><i class="fas fa-search"></i> Cari Buku</a>
            </li>
            <li class="<?= $this->uri->segment(2) == 'pinjaman' ? 'active' : '' ?>">
                <a href="<?= base_url('index.php/user/pinjaman') ?>"><i class="fas fa-bookmark"></i> Pinjaman Saya</a>
            </li>
            <li class="<?= $this->uri->segment(2) == 'profil' ? 'active' : '' ?>">
                <a href="<?= base_url('index.php/user/profil') ?>"><i class="fas fa-user"></i> Profil</a>
            </li>
            <hr mx-4>
            <li>
                <a href="<?= base_url('index.php/user/logout') ?>" class="text-danger"><i class="fas fa-sign-out-alt"></i> Keluar</a>
            </li>
        </ul>
    </nav>

    <!-- MAIN CONTENT -->
    <div id="content">
        <!-- Banner Sapaan -->
        <div class="user-card d-flex align-items-center justify-content-between">
            <div>
                <?php 
                    $clean_name = str_ireplace(' siswa', '', $nama_user); 
                    $display_name = ucwords(strtolower($clean_name));
                ?>
                <h2 class="font-weight-bold">Halo, <?= $display_name ? $display_name : 'Siswa'; ?>! 👋</h2>
                <p class="mb-0">Selamat datang kembali di perpustakaan digital kamu.</p>
            </div>
            <img src="https://cdn-icons-png.flaticon.com/512/1995/1995515.png" alt="User" style="width: 100px; opacity: 0.8;">
        </div>

        <!-- Statistik (UPDATE: Card sekarang berfungsi sebagai link) -->
        <div class="row mb-4">
            <div class="col-md-4">
                <a href="<?= base_url('index.php/user/pinjaman') ?>" class="stat-card">
                    <div class="icon-box bg-light text-primary"><i class="fas fa-book"></i></div>
                    <h3 class="font-weight-bold"><?= $total_pinjaman; ?></h3>
                    <p class="text-muted mb-0">Total Pinjaman</p>
                </a>
            </div>
            <div class="col-md-4">
                <a href="<?= base_url('index.php/user/pinjaman') ?>" class="stat-card">
                    <div class="icon-box bg-light text-warning"><i class="fas fa-clock"></i></div>
                    <h3 class="font-weight-bold"><?= $sedang_dipinjam; ?></h3>
                    <p class="text-muted mb-0">Sedang Dipinjam</p>
                </a>
            </div>
            <div class="col-md-4">
                <a href="<?= base_url('index.php/user/pinjaman') ?>" class="stat-card">
                    <div class="icon-box bg-light text-success"><i class="fas fa-check-circle"></i></div>
                    <h3 class="font-weight-bold"><?= $selesai_dibaca; ?></h3>
                    <p class="text-muted mb-0">Selesai Dibaca</p>
                </a>
            </div>
        </div>

        <!-- Tabel Buku yang Dipinjam -->
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-body">
                <h5 class="font-weight-bold mb-4">Buku yang Kamu Pinjam</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr class="text-muted small">
                                <th>SAMPUL</th>
                                <th>JUDUL</th>
                                <th>TGL PINJAM</th>
                                <th>BATAS KEMBALI</th>
                                <th class="text-center">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($buku_pinjam)): ?>
                                <tr><td colspan="5" class="text-center text-muted">Kamu tidak sedang meminjam buku.</td></tr>
                            <?php else: ?>
                                <?php foreach($buku_pinjam as $b): ?>
                                <tr>
                                    <td>
                                        <img src="<?= base_url('assets/img/' . $b['sampul']) ?>" class="img-cover" onerror="this.src='https://via.placeholder.com/45x65?text=No+Cover'">
                                    </td>
                                    <td>
                                        <p class="mb-0 font-weight-bold"><?= $b['judul'] ?></p>
                                        <small class="text-muted"><?= $b['penulis'] ?></small>
                                    </td>
                                    <td class="align-middle"><?= isset($b['tanggal_pinjam']) ? $b['tanggal_pinjam'] : (isset($b['tgl_pinjam']) ? $b['tgl_pinjam'] : '-') ?></td>
                                    <td class="align-middle text-danger font-weight-bold"><?= isset($b['batas_pengembalian']) ? $b['batas_pengembalian'] : (isset($b['batas_kembali']) ? $b['batas_kembali'] : '-') ?></td>
                                    <td class="align-middle text-center">
                                        <span class="badge badge-warning text-white px-3 py-2" style="border-radius:20px"><?= $b['status'] ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>