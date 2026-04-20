<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul; ?></title>
    <!-- Menambahkan Font Awesome untuk ikon tombol -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #f0f2f5; 
            display: flex; 
            flex-direction: column;
            align-items: center; 
            padding-top: 30px; 
            margin: 0;
        }

        /* Container Tombol Navigasi */
        .no-print-area {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }

        .btn-nav {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .btn-back { background-color: #6c757d; color: white; }
        .btn-print { background-color: #4e73df; color: white; }
        .btn-nav:hover { opacity: 0.8; transform: translateY(-2px); }

        /* Desain Kartu Anggota */
        .card-container { 
            width: 450px; 
            height: 260px; 
            background: white; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.15); 
            position: relative; 
            overflow: hidden; 
            border: 1px solid #e3e6f0; 
        }
        
        .card-header { 
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); 
            padding: 20px;
            color: white;
            height: 60px;
        }

        .card-header h3 { margin: 0; font-size: 20px; letter-spacing: 1.5px; text-transform: uppercase; }
        .card-header p { margin: 2px 0 0; font-size: 11px; opacity: 0.9; }

        .card-body { display: flex; padding: 25px 20px; gap: 20px; }

        .photo-wrapper { 
            width: 110px; 
            height: 135px; 
            background: #ffffff;
            border-radius: 10px;
            padding: 4px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-top: -45px;
            z-index: 10;
        }

        .photo-wrapper img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            border-radius: 6px;
        }

        .info-table { flex: 1; margin-top: -5px; }
        .info-table table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 5px 0; font-size: 13px; color: #333; vertical-align: top; }
        
        .label-cell { 
            font-weight: 800; 
            width: 90px; 
            color: #4e73df; 
            font-size: 11px; 
            text-transform: uppercase;
        }

        .value-cell { font-weight: 600; color: #2e2f37; }

        .card-footer { 
            position: absolute; 
            bottom: 0; 
            width: 100%; 
            background: #f8f9fc; 
            padding: 10px 20px; 
            font-size: 10px; 
            color: #858796; 
            border-top: 1px solid #eaecf4;
            display: flex;
            justify-content: space-between;
            box-sizing: border-box;
        }

        /* Pengaturan Cetak (Hanya kartu yang tampil) */
        @media print {
            body { background: none; padding: 0; }
            .no-print-area { display: none !important; }
            .card-container { 
                box-shadow: none; 
                border: 1px solid #ccc;
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <!-- Tombol Navigasi (Tidak akan ikut terprint) -->
    <div class="no-print-area">
        <a href="<?= base_url('index.php/anggota'); ?>" class="btn-nav btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Data Anggota
        </a>
        <button onclick="window.print()" class="btn-nav btn-print">
            <i class="fas fa-print"></i> Cetak Kartu
        </button>
    </div>

    <!-- Tampilan Kartu -->
    <div class="card-container">
        <div class="card-header">
            <h3>PERPUS AMI</h3>
            <p>Perpustakaan Digital Masa Kini</p>
        </div>

        <div class="card-body">
            <div class="photo-wrapper">
                <img src="<?= $user->foto ? base_url('assets/img/profile/').$user->foto : 'https://ui-avatars.com/api/?name='.urlencode($user->nama_lengkap); ?>" alt="Foto Profil">
            </div>
            
            <div class="info-table">
                <table>
                    <tr>
                        <td class="label-cell">ID Anggota</td>
                        <td class="value-cell">: AMI-<?= str_pad($user->id, 4, '0', STR_PAD_LEFT); ?></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Nama</td>
                        <td class="value-cell">: <?= strtoupper($user->nama_lengkap); ?></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Kelas</td>
                        <td class="value-cell">: <?= $user->kelas; ?></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Username</td>
                        <td class="value-cell">: <?= $user->username; ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card-footer">
            <span>Berlaku selama menjadi siswa aktif</span>
            <span style="font-weight: bold; color: #4e73df;">PERPUSTAKAANKUU</span>
        </div>
    </div>

</body>
</html>