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
        ul li a { color: #555; text-decoration: none; display: block; padding: 12px 15px; border-radius: 10px; margin: 0 20px; font-weight: 500; }
        ul li.active a { background: #eef5ff; color: #007bff; }
        #content { width: 100%; padding: 30px; }
        .img-profile { width: 150px; height: 150px; object-fit: cover; border: 5px solid #fff; transition: 0.3s; }
        .img-profile:hover { transform: scale(1.05); }
        .info-label { font-size: 0.75rem; font-weight: 700; color: #adb5bd; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; }
        .info-value { font-weight: 600; color: #333; margin-bottom: 20px; }
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
            <li><a href="<?= base_url('index.php/user/pinjaman') ?>"><i class="fas fa-bookmark"></i> Pinjaman Saya</a></li>
            <li class="active"><a href="<?= base_url('index.php/user/profil') ?>"><i class="fas fa-user"></i> Profil</a></li>
            <hr class="mx-4">
            <li><a href="<?= base_url('index.php/user/logout') ?>" class="text-danger"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
        </ul>
    </nav>

    <!-- CONTENT -->
    <div id="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="font-weight-bold text-dark mb-0">Profil Pengguna</h3>
            <span class="badge badge-pill badge-primary px-3 py-2">ID Siswa: #<?= isset($user['id']) ? $user['id'] : '0'; ?></span>
        </div>

        <div class="row">
            <!-- Kolom Foto -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center p-4" style="border-radius: 15px;">
                    <?php 
                        $user_foto = isset($user['foto']) ? $user['foto'] : '';
                        $path_foto = './assets/img/profile/' . $user_foto;
                        $display_foto = (!empty($user_foto) && file_exists($path_foto)) ? base_url('assets/img/profile/' . $user_foto) : "https://ui-avatars.com/api/?name=" . urlencode($nama_user) . "&background=007bff&color=fff&size=150";
                    ?>
                    <img src="<?= $display_foto ?>" class="rounded-circle mx-auto shadow-sm img-profile mb-4">
                    
                    <form action="<?= base_url('index.php/user/update_foto') ?>" method="post" enctype="multipart/form-data" id="formFoto">
                        <input type="file" name="foto_profil" id="foto_profil" hidden onchange="document.getElementById('formFoto').submit()">
                        <button type="button" class="btn btn-outline-primary btn-sm btn-block font-weight-bold" onclick="document.getElementById('foto_profil').click()">
                            <i class="fas fa-camera mr-1"></i> Ganti Foto Profil
                        </button>
                    </form>
                </div>
            </div>

            <!-- Kolom Detail Informasi -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h6 class="font-weight-bold text-primary mb-0"><i class="fas fa-info-circle mr-2"></i>Informasi Akun</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="info-label">Nama Lengkap</p>
                                <p class="info-value">
                                    <?php 
                                        $full_name = isset($user['nama_lengkap']) ? $user['nama_lengkap'] : $nama_user;
                                        $clean_name = rtrim(str_ireplace('siswa', '', $full_name));
                                        echo $clean_name; 
                                    ?>
                                </p>
                                <p class="info-label">NIS (Nomor Induk Siswa)</p>
                                <p class="info-value"><?= isset($user['nis']) ? $user['nis'] : '21628068' ?></p>
                                <p class="info-label">Username / Email</p>
                                <p class="info-value"><?= isset($user['username']) ? $user['username'] : '-' ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="info-label">Kelas</p>
                                <p class="info-value"><?= isset($user['kelas']) ? $user['kelas'] : 'XII PPLG' ?></p>
                                <p class="info-label">Status Keanggotaan</p>
                                <p class="info-value"><span class="text-success font-weight-bold">● Aktif</span></p>
                                <p class="info-label">Tanggal Bergabung</p>
                                <p class="info-value"><?= isset($user['tgl_join']) ? date('d M Y', strtotime($user['tgl_join'])) : '18 Apr 2026' ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="text-right">
                            <?php 
                                // GANTI NOMOR DI BAWAH INI (Gunakan kode negara, misal 62812...)
                                $no_admin = "628987722920"; 
                                
                                // Menyusun pesan agar rapi dan terhindar dari error URL
                                $teks = "Halo Admin Perpustakaankuu,\n\nSaya ingin mengajukan perubahan data profil:\n";
                                $teks .= "ID Siswa: #" . (isset($user['id']) ? $user['id'] : '0') . "\n";
                                $teks .= "Nama: " . $clean_name . "\n";
                                $teks .= "NIS: " . (isset($user['nis']) ? $user['nis'] : '21628068') . "\n\n";
                                $teks .= "Data yang ingin diubah: [Tuliskan di sini]";
                                
                                // Encode pesan agar otomatis bisa dibaca WhatsApp
                                $url_wa = "https://api.whatsapp.com/send?phone=" . $no_admin . "&text=" . rawurlencode($teks);
                            ?>
                            <a href="<?= $url_wa ?>" target="_blank" class="btn btn-primary btn-sm font-weight-bold shadow-sm" style="border-radius: 8px; padding: 8px 20px;">
                                <i class="fas fa-edit mr-1"></i> Ajukan Perubahan Data
                            </a>
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