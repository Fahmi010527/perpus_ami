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
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7f6; }
        #sidebar { min-width: 250px; max-width: 250px; min-height: 100vh; background: #fff; border-right: 1px solid #eee; }
        .sidebar-header { padding: 20px; text-align: center; border-bottom: 1px solid #f8f9fa; }
        ul.components { padding: 20px 0; }
        ul li a { color: #555; text-decoration: none; display: block; padding: 12px 15px; border-radius: 10px; margin: 0 20px; font-weight: 500; transition: 0.3s; }
        ul li.active a { background: #eef5ff; color: #007bff; }
        #content { width: 100%; padding: 30px; }

        /* Detail Book Styling */
        .card-detail { border: none; border-radius: 20px; overflow: hidden; background: #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .img-detail-container { padding: 20px; background: #f8f9fa; text-align: center; }
        .img-detail { width: 100%; max-width: 300px; border-radius: 15px; box-shadow: 0 15px 35px rgba(0,0,0,0.2); }
        .info-section { padding: 40px; }
        .book-title { font-size: 28px; font-weight: 600; color: #333; margin-bottom: 5px; }
        .book-author { font-size: 18px; color: #007bff; margin-bottom: 20px; }
        .meta-box { background: #f8f9fa; border-radius: 12px; padding: 15px; margin-bottom: 20px; }
        .meta-item { border-right: 1px solid #ddd; text-align: center; }
        .meta-item:last-child { border-right: none; }
        .label-meta { font-size: 12px; color: #888; text-transform: uppercase; display: block; }
        .value-meta { font-weight: 600; color: #333; }
        .synopsis-title { font-weight: 600; color: #333; margin-top: 25px; margin-bottom: 10px; border-left: 4px solid #007bff; padding-left: 10px; }
        .synopsis-text { color: #666; line-height: 1.8; text-align: justify; }
        .btn-pinjam { border-radius: 12px; padding: 12px 30px; font-weight: 600; transition: 0.3s; }
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
            <li><a href="<?= base_url('index.php/user') ?>"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="active"><a href="<?= base_url('index.php/user/cari_buku') ?>"><i class="fas fa-search"></i> Cari Buku</a></li>
            <li><a href="<?= base_url('index.php/user/pinjaman') ?>"><i class="fas fa-bookmark"></i> Pinjaman Saya</a></li>
            <li><a href="<?= base_url('index.php/user/profil') ?>"><i class="fas fa-user"></i> Profil</a></li>
            <hr class="mx-4">
            <li><a href="<?= base_url('index.php/user/logout') ?>" class="text-danger"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
        </ul>
    </nav>

    <!-- MAIN CONTENT -->
    <div id="content">
        <div class="mb-4">
            <a href="<?= base_url('index.php/user/cari_buku') ?>" class="btn btn-light btn-sm mb-3 shadow-sm" style="border-radius: 8px;">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Katalog
            </a>
        </div>

        <div class="card card-detail">
            <div class="row no-gutters">
                <div class="col-md-4 img-detail-container d-flex align-items-center justify-content-center">
                    <img src="<?= base_url('assets/img/' . $buku['cover']) ?>" class="img-detail" onerror="this.src='https://via.placeholder.com/300x450?text=No+Cover'">
                </div>
                <div class="col-md-8">
                    <div class="info-section">
                        <h1 class="book-title"><?= $buku['judul'] ?></h1>
                        <p class="book-author">Oleh <?= $buku['penulis'] ?></p>

                        <div class="row meta-box">
                            <div class="col-4 meta-item">
                                <span class="label-meta">Kategori</span>
                                <span class="value-meta"><?= $buku['kategori'] ?></span>
                            </div>
                            <div class="col-4 meta-item">
                                <span class="label-meta">Tahun Terbit</span>
                                <span class="value-meta"><?= $buku['tahun_terbit'] ?></span>
                            </div>
                            <div class="col-4 meta-item">
                                <span class="label-meta">Tersedia</span>
                                <span class="value-meta <?= $buku['stok'] > 0 ? 'text-success' : 'text-danger' ?>">
                                    <?= $buku['stok'] ?> Buku
                                </span>
                            </div>
                        </div>

                        <h6 class="synopsis-title">Sinopsis Buku</h6>
                        <p class="synopsis-text">
                            <?= !empty($buku['sinopsis']) ? $buku['sinopsis'] : 'Sinopsis belum tersedia untuk buku ini.' ?>
                        </p>

                        <div class="mt-5">
                            <?php if($buku['stok'] > 0): ?>
                                <a href="<?= base_url('index.php/user/proses_pinjam/' . $buku['id_buku']) ?>" 
                                   class="btn btn-primary btn-pinjam px-5 shadow"
                                   onclick="return confirm('Apakah kamu yakin ingin meminjam buku ini?')">
                                    <i class="fas fa-shopping-cart mr-2"></i> Pinjam Buku Sekarang
                                </a>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-pinjam px-5" disabled>
                                    <i class="fas fa-times-circle mr-2"></i> Stok Habis
                                </button>
                            <?php endif; ?>
                            
                            <button class="btn btn-outline-info btn-pinjam ml-2">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>