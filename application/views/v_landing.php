<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <!-- CSS Dependencies -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #ffffff; color: #333; }
        
        /* Navbar & Logo */
        .navbar { padding: 15px 0; border-bottom: 1px solid #eee; }
        .logo-box {
            width: 40px; height: 40px;
            background: #007bff; color: white;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            margin-right: 12px; font-size: 1.2rem;
            box-shadow: 0 4px 10px rgba(0,123,255,0.3);
        }

        /* Search Bar */
        .search-container {
            background: #f1f3f4; border-radius: 50px;
            padding: 5px 20px; display: flex; align-items: center;
            width: 100%; max-width: 500px; margin: 0 auto;
        }
        .search-container input { background: transparent; border: none; padding: 10px; width: 100%; }
        .search-container input:focus { outline: none; }

        /* Kategori */
        .btn-category {
            border-radius: 50px; padding: 8px 20px;
            font-size: 14px; font-weight: 500; margin: 5px;
            border: 1px solid #ddd; background: white; color: #333;
            transition: 0.3s; cursor: pointer;
        }
        .btn-category:hover, .btn-category.active {
            background: #007bff; color: white !important; border-color: #007bff; text-decoration: none;
        }

        /* Card Buku */
        .card-buku {
            border: none; border-radius: 12px; transition: 0.3s;
            overflow: hidden; background: #fff; padding: 10px;
            text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .card-buku:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
        .img-wrapper { background: #f8f9fa; padding: 10px; border-radius: 12px; }
        .img-cover { height: 180px; width: auto; max-width: 100%; border-radius: 8px; object-fit: cover; }
        .book-title { font-size: 14px; font-weight: 600; margin-top: 10px; color: #333; }
        .book-author { font-size: 12px; color: #777; margin-bottom: 10px; }

        /* Modal Styling */
        .modal-content { border: none; border-radius: 20px; overflow: hidden; }
        .img-detail { border-radius: 15px; width: 100%; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

        /* Footer Modern */
        .footer-custom {
            background: #f8f9fa; color: #333;
            padding: 60px 0 30px; margin-top: 80px;
            border-top: 1px solid #eee;
        }
        .footer-link { color: #666; transition: 0.3s; text-decoration: none; display: block; margin-bottom: 10px; }
        .footer-link:hover { color: #007bff; text-decoration: none; padding-left: 5px; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center font-weight-bold text-primary" href="<?= base_url('index.php') ?>">
            <div class="logo-box">
                <i class="fas fa-book-reader"></i>
            </div>
            <span>Perpustakaankuu</span>
        </a>
        
        <div class="collapse navbar-collapse">
            <div class="search-container">
                <i class="fas fa-search text-primary"></i>
                <input type="text" id="search-input" placeholder="Cari buku favoritmu...">
            </div>
            
            <div class="navbar-nav ml-auto align-items-center">
                <a href="<?= base_url('index.php/auth') ?>" class="nav-link mr-3 font-weight-bold text-dark">Login</a>
                <a href="<?= base_url('index.php/register') ?>" class="btn btn-primary font-weight-bold rounded-pill px-4 shadow-sm">Daftar Akun</a>
            </div>
        </div>
    </div>
</nav>

<!-- HERO SECTION -->
<div class="container mt-5 text-center">
    <h2 class="font-weight-bold">Mau Baca Apa Hari Ini?</h2>
    <p class="text-muted">Akses ribuan koleksi buku perpustakaan sekolah secara digital.</p>
    <div class="d-flex flex-wrap justify-content-center mt-4">
        <a class="btn-category active" data-filter="all">Semua</a>
        <a class="btn-category" data-filter="teknologi">Teknologi</a>
        <a class="btn-category" data-filter="kisah inspiratif">Kisah Inspiratif</a>
        <a class="btn-category" data-filter="komik">Komik</a>
        <a class="btn-category" data-filter="agama">Agama</a>
    </div>
</div>

<!-- KATALOG BUKU -->
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="font-weight-bold"><i class="fas fa-book-open text-primary mr-2"></i> Katalog Koleksi</h5>
    </div>

    <div class="row" id="book-list">
        <?php foreach($buku as $b): ?>
        <div class="col-6 col-md-3 col-lg-2 mb-4 filter-item" 
             data-category="<?= strtolower($b->kategori) ?>" 
             data-title="<?= strtolower($b->judul) ?>">
            
            <div class="card-buku h-100 d-flex flex-column" style="cursor: pointer;" data-toggle="modal" data-target="#modalDetail<?= $b->id_buku ?>">
                <div class="img-wrapper">
                    <img src="<?= base_url('assets/img/buku/'.$b->cover) ?>" class="img-cover" alt="<?= $b->judul ?>">
                </div>
                <div class="book-title text-truncate px-2"><?= $b->judul ?></div>
                <div class="book-author text-truncate mb-auto px-2"><?= $b->penulis ?></div>
                
                <div class="px-2 pb-2 mt-3">
                    <button class="btn btn-sm btn-outline-primary btn-block rounded-pill font-weight-bold">
                        Detail Buku
                    </button>
                </div>
            </div>

            <!-- MODAL DETAIL -->
            <div class="modal fade" id="modalDetail<?= $b->id_buku ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-body p-4">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <div class="row mt-3">
                                <div class="col-md-4 text-center">
                                    <img src="<?= base_url('assets/img/buku/'.$b->cover) ?>" class="img-detail mb-3">
                                </div>
                                <div class="col-md-8">
                                    <span class="badge badge-primary mb-2"><?= $b->kategori ?></span>
                                    <h3 class="font-weight-bold"><?= $b->judul ?></h3>
                                    <p class="text-muted">Ditulis oleh: <strong><?= $b->penulis ?></strong></p>
                                    <hr>
                                    <h6 class="font-weight-bold">Sinopsis:</h6>
                                    <p class="text-secondary small">
                                        <?= (isset($b->deskripsi) && $b->deskripsi != '') ? $b->deskripsi : "Belum ada sinopsis untuk buku ini. Silakan daftar untuk mendapatkan akses penuh membaca koleksi kami."; ?>
                                    </p>
                                    <div class="mt-4">
                                        <a href="<?= base_url('index.php/register') ?>" class="btn btn-primary btn-lg rounded-pill px-5 shadow">Pinjam Sekarang</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- FOOTER -->
<footer class="footer-custom">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="logo-box" style="width: 35px; height: 35px; font-size: 1rem;">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <h5 class="font-weight-bold text-primary mb-0">Perpustakaankuu</h5>
                </div>
                <p class="small text-muted">Solusi perpustakaan digital sekolah yang cerdas dan modern. Baca kapan saja, di mana saja.</p>
            </div>
            <div class="col-md-2 col-6 mb-4">
                <h6 class="font-weight-bold mb-3">Navigasi</h6>
                <a href="#" class="footer-link small">Beranda</a>
                <a href="#" class="footer-link small">Katalog</a>
                <a href="#" class="footer-link small">Kontak</a>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <h6 class="font-weight-bold mb-3">Dukungan</h6>
                <a href="#" class="footer-link small">Pusat Bantuan</a>
                <a href="#" class="footer-link small">Cara Meminjam</a>
                <a href="#" class="footer-link small">Kebijakan Privasi</a>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="font-weight-bold mb-3">Sosial Media</h6>
                <div class="d-flex">
                    <a href="#" class="btn btn-outline-primary btn-sm rounded-circle mr-2"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="btn btn-outline-primary btn-sm rounded-circle mr-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-outline-primary btn-sm rounded-circle"><i class="fab fa-twitter"></i></a>
                </div>
                <p class="small text-muted mt-3"><i class="fas fa-map-marker-alt mr-1"></i> Cibinong, Kab. Bogor</p>
            </div>
        </div>
        <hr>
        <div class="text-center mt-4">
            <p class="small text-muted mb-0">© 2026 Perpustakaankuu. Dibuat dengan <i class="fas fa-heart text-danger"></i> untuk Literasi Indonesia.</p>
        </div>
    </div>
</footer>

<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function(){
    // Filter Kategori
    $('.btn-category').click(function(){
        const value = $(this).attr('data-filter');
        $('.btn-category').removeClass('active');
        $(this).addClass('active');

        if(value == "all") {
            $('.filter-item').show('400');
        } else {
            $(".filter-item").not('[data-category="'+value+'"]').hide('400');
            $('.filter-item').filter('[data-category="'+value+'"]').show('400');
        }
    });

    // Search Bar
    $("#search-input").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#book-list .filter-item").filter(function() {
            $(this).toggle($(this).attr('data-title').indexOf(value) > -1)
        });
    });
});
</script>

</body>
</html>