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

        .book-card { border: none; border-radius: 15px; overflow: hidden; transition: 0.3s; background: #fff; height: 100%; }
        .book-card:hover { transform: translateY(-10px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .book-img-container { height: 250px; overflow: hidden; position: relative; background: #eee; }
        .book-img { width: 100%; height: 100%; object-fit: cover; }
        .badge-category { position: absolute; top: 10px; right: 10px; font-size: 10px; text-transform: uppercase; z-index: 2; }
        
        .search-container { background: #fff; border-radius: 15px; padding: 20px; margin-bottom: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .form-control-custom { border-radius: 10px; border: 1px solid #eee; padding: 12px 20px; height: auto; transition: 0.3s; }
        .form-control-custom:focus { box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.1); border-color: #007bff; }
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
            <h3 class="font-weight-bold text-dark mb-1">Cari Koleksi Buku</h3>
            <p class="text-muted">Temukan buku favoritmu untuk dipinjam hari ini.</p>
        </div>

        <!-- Form Pencarian (Live Search) -->
        <div class="search-container">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0" style="border-radius: 10px 0 0 10px; border: 1px solid #eee;">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                </div>
                <input type="text" id="search-input" class="form-control form-control-custom border-left-0" placeholder="Ketik judul buku, penulis, atau kategori..." autocomplete="off">
            </div>
        </div>

        <!-- Container Daftar Buku -->
        <div class="row" id="book-list">
            <?php foreach($buku as $bk): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4 book-item">
                <div class="card book-card shadow-sm">
                    <div class="book-img-container">
                        <span class="badge badge-primary badge-category shadow-sm"><?= $bk['kategori'] ?></span>
                        <img src="<?= base_url('assets/img/' . $bk['cover']) ?>" class="book-img" onerror="this.src='https://via.placeholder.com/250x350?text=No+Cover'">
                    </div>
                    <div class="card-body">
                        <h6 class="font-weight-bold text-dark text-truncate judul-buku" title="<?= $bk['judul'] ?>"><?= $bk['judul'] ?></h6>
                        <p class="text-muted small mb-3 penulis-buku"><i class="fas fa-pen-nib mr-1"></i> <?= $bk['penulis'] ?></p>
                        <p class="d-none kategori-buku"><?= $bk['kategori'] ?></p>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small font-weight-bold <?= $bk['stok'] > 0 ? 'text-success' : 'text-danger' ?>">
                                <?= $bk['stok'] > 0 ? 'Tersedia: ' . $bk['stok'] : 'Stok Habis' ?>
                            </span>
                            <a href="<?= base_url('index.php/user/detail_buku/' . $bk['id_buku']) ?>" class="btn btn-primary btn-sm px-3 shadow-sm" style="border-radius: 8px;">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Tampilan jika tidak ditemukan -->
        <div id="not-found" class="text-center py-5 d-none">
            <img src="https://illustrations.popsy.co/white/surprised-woman.svg" style="width: 200px;" class="mb-4">
            <h5 class="text-muted">Yah, buku yang kamu cari tidak ditemukan...</h5>
            <button onclick="resetSearch()" class="btn btn-outline-primary mt-3">Lihat Semua Buku</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function(){
        $("#search-input").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            var visibleCount = 0;

            $(".book-item").filter(function() {
                var match = $(this).find('.judul-buku').text().toLowerCase().indexOf(value) > -1 || 
                            $(this).find('.penulis-buku').text().toLowerCase().indexOf(value) > -1 ||
                            $(this).find('.kategori-buku').text().toLowerCase().indexOf(value) > -1;
                
                $(this).toggle(match);
                if(match) visibleCount++;
            });

            // Tampilkan pesan "Tidak Ditemukan" jika hasil 0
            if(visibleCount === 0) {
                $("#not-found").removeClass("d-none");
            } else {
                $("#not-found").addClass("d-none");
            }
        });
    });

    function resetSearch() {
        $("#search-input").val("");
        $(".book-item").show();
        $("#not-found").addClass("d-none");
        $("#search-input").focus();
    }
</script>

</body>
</html>