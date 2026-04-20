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

        .card-table { border: none; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); background: #fff; }
        .img-cover { width: 50px; height: 70px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        
        /* Custom Badges */
        .badge-status { border-radius: 12px; padding: 6px 15px; font-weight: 600; font-size: 11px; text-transform: uppercase; }
        .status-dipinjam { background-color: #fff4e5; color: #ff9800; }
        .status-dikembalikan { background-color: #e8f5e9; color: #4caf50; }
        .status-terlambat { background-color: #ffebee; color: #f44336; }

        .table thead th { border-top: none; background-color: #f8f9fa; color: #888; font-size: 12px; letter-spacing: 1px; padding: 15px; }
        .table tbody td { vertical-align: middle; padding: 15px; border-bottom: 1px solid #f8f9fa; }
        
        /* Highlight row if there is a fine */
        .row-denda { background-color: #fff5f5; }

        /* Modal Style */
        .modal-content { border: none; border-radius: 20px; }
        .instruction-step { display: flex; align-items: flex-start; margin-bottom: 15px; }
        .step-number { background: #007bff; color: #fff; width: 25px; height: 25px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; margin-right: 15px; flex-shrink: 0; margin-top: 3px; }
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
            <li><a href="<?= base_url('index.php/user/cari_buku') ?>"><i class="fas fa-search"></i> Cari Buku</a></li>
            <li class="active"><a href="<?= base_url('index.php/user/pinjaman') ?>"><i class="fas fa-bookmark"></i> Pinjaman Saya</a></li>
            <li><a href="<?= base_url('index.php/user/profil') ?>"><i class="fas fa-user"></i> Profil</a></li>
            <hr class="mx-4">
            <li><a href="<?= base_url('index.php/user/logout') ?>" class="text-danger"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
        </ul>
    </nav>

    <!-- MAIN CONTENT -->
    <div id="content">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h3 class="font-weight-bold text-dark mb-1">Riwayat Pinjaman</h3>
                <p class="text-muted">Pantau buku yang sedang kamu baca dan riwayat pengembalianmu.</p>
            </div>
            <!-- Alert jika ada pesan sukses/gagal -->
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success border-0 shadow-sm rounded-pill px-4">
                    <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger border-0 shadow-sm rounded-pill px-4">
                    <i class="fas fa-exclamation-circle mr-2"></i> <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="card card-table">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th class="pl-4">BUKU</th>
                                <th>TGL PINJAM</th>
                                <th>BATAS KEMBALI</th>
                                <th>Denda</th>
                                <th>Status Denda</th>
                                <th class="text-center">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($riwayat)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <img src="https://illustrations.popsy.co/white/reading-a-book.svg" style="width: 150px;" class="mb-3">
                                        <p class="text-muted">Kamu belum pernah meminjam buku apapun.</p>
                                        <a href="<?= base_url('index.php/user/cari_buku') ?>" class="btn btn-primary btn-sm">Cari Buku Sekarang</a>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($riwayat as $r): ?>
                                    <?php 
                                        $status_class = 'status-dipinjam';
                                        if($r['status'] == 'dikembalikan') $status_class = 'status-dikembalikan';
                                        
                                        $is_denda = ($r['denda'] > 0 && $r['status_denda'] == 'belum_lunas');
                                    ?>
                                    <tr class="<?= $is_denda ? 'row-denda' : '' ?>">
                                        <td class="pl-4">
                                            <div class="d-flex align-items-center">
                                                <img src="<?= base_url('assets/img/' . $r['sampul']) ?>" class="img-cover mr-3" onerror="this.src='https://via.placeholder.com/50x70?text=No+Cover'">
                                                <div>
                                                    <span class="font-weight-bold text-dark d-block"><?= $r['judul'] ?></span>
                                                    <small class="text-muted"><?= $r['penulis'] ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="text-muted small"><?= date('d M Y', strtotime($r['tanggal_pinjam'])) ?></span></td>
                                        <td>
                                            <span class="small font-weight-bold <?= $is_denda ? 'text-danger' : 'text-dark' ?>">
                                                <?= date('d M Y', strtotime($r['batas_pengembalian'])) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold <?= $r['denda'] > 0 ? 'text-danger' : 'text-muted' ?>">
                                                Rp <?= number_format($r['denda'], 0, ',', '.') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if($r['denda'] > 0): ?>
                                                <?php if($r['status_denda'] == 'belum_lunas'): ?>
                                                    <span class="badge badge-pill badge-danger shadow-sm" style="font-size: 10px;">BELUM LUNAS</span>
                                                    <button class="btn btn-link btn-sm d-block p-0 text-primary" style="font-size: 11px; text-decoration: none;" data-toggle="modal" data-target="#modalBayar">
                                                        <i class="fas fa-info-circle"></i> Cara Bayar
                                                    </button>
                                                <?php else: ?>
                                                    <span class="badge badge-pill badge-success shadow-sm" style="font-size: 10px;">LUNAS</span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted small">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge-status <?= $status_class ?>">
                                                <?= $r['status'] ?>
                                            </span>
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

<!-- MODAL CARA BAYAR -->
<div class="modal fade" id="modalBayar" tabindex="-1" aria-labelledby="modalBayarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title font-weight-bold" id="modalBayarLabel">Instruksi Pembayaran Denda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-4 pb-4">
                <p class="text-muted mb-4">Silakan ikuti langkah-langkah di bawah ini untuk melunasi denda Anda:</p>
                
                <div class="instruction-step">
                    <div class="step-number">1</div>
                    <div>
                        <p class="mb-1 font-weight-bold">Kunjungi Perpustakaan</p>
                        <p class="small text-muted">Bawa buku yang terlambat dan tunjukkan kartu siswa Anda ke Pustakawan.</p>
                    </div>
                </div>

                <div class="instruction-step">
                    <div class="step-number">2</div>
                    <div>
                        <p class="mb-1 font-weight-bold">Bayar Secara Tunai</p>
                        <p class="small text-muted">Lakukan pembayaran sesuai nominal denda yang tertera di aplikasi kepada petugas.</p>
                    </div>
                </div>

                <div class="instruction-step">
                    <div class="step-number">3</div>
                    <div>
                        <p class="mb-1 font-weight-bold">Konfirmasi Petugas</p>
                        <p class="small text-muted">Petugas akan memperbarui status denda Anda di sistem menjadi <b>LUNAS</b>.</p>
                    </div>
                </div>

                <div class="alert alert-info border-0 mt-3" style="border-radius: 12px;">
                    <small><i class="fas fa-lightbulb mr-1"></i> Setelah denda lunas, Anda bisa langsung meminjam buku kembali!</small>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary btn-block rounded-pill" data-dismiss="modal">Saya Mengerti</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>