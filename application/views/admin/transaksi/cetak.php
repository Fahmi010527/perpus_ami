<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $judul; ?></title>
    <!-- Memuat Bootstrap untuk tampilan yang rapi -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome untuk ikon tombol kembali -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            color: #333; 
            background-color: #fff;
        }
        .line-title { 
            border: 0; 
            border-style: inset; 
            border-top: 2px solid #000; 
        }
        .table th { 
            background-color: #f8f9fa !important; 
        }
        
        /* CSS KRITIKAL: Menyembunyikan elemen saat diprint */
        @media print {
            .no-print { 
                display: none !important; 
            }
            .container {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- Tombol Navigasi (Hanya muncul di layar, tidak di kertas) -->
    <div class="container no-print mt-4">
        <div class="row">
            <div class="col-12">
                <a href="<?= base_url('index.php/transaksi'); ?>" class="btn btn-secondary shadow-sm px-4" style="border-radius: 10px;">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard Transaksi
                </a>
                <button onclick="window.print()" class="btn btn-primary shadow-sm px-4 ml-2" style="border-radius: 10px;">
                    <i class="fas fa-print mr-2"></i> Cetak Ulang
                </button>
            </div>
        </div>
        <hr>
    </div>

    <div class="container mt-5">
        <!-- Header Laporan -->
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="font-weight-bold mb-0">PERPUS AMI</h1>
                <p class="lead">Laporan Data Transaksi Peminjaman Buku</p>
                <hr class="line-title">
            </div>
        </div>

        <!-- Tabel Data -->
        <table class="table table-bordered mt-4">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>ID Transaksi</th>
                    <th>Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($transaksi as $t): ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td class="text-center">TRX-<?= $t->id_transaksi; ?></td>
                    <td><?= $t->nama_peminjam; ?></td>
                    <td><?= $t->judul_buku; ?></td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($t->tanggal_pinjam)); ?></td>
                    <td class="text-center text-uppercase">
                        <span class="font-weight-bold"><?= $t->status; ?></span>
                    </td>
                    <td class="text-right">
                        Rp <?= number_format($t->denda, 0, ',', '.'); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Tanda Tangan -->
        <div class="row mt-5">
            <div class="col-md-4 offset-md-8 text-center">
                <p>Bogor, <?= date('d F Y'); ?></p>
                <p>Petugas Perpustakaan,</p>
                <br><br><br>
                <p class="font-weight-bold">( ____________________ )</p>
            </div>
        </div>
    </div>

</body>
</html>