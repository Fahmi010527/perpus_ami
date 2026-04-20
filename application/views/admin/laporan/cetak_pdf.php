<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Perpustakaan</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; padding: 30px; color: #333; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 15px; margin-bottom: 30px; }
        .header h2 { margin: 0; text-transform: uppercase; font-size: 24px; color: #224abe; }
        .header p { margin: 5px 0; font-size: 14px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 12px 8px; text-align: center; font-size: 12px; }
        th { background-color: #f2f2f2; font-weight: bold; text-transform: uppercase; }
        
        .text-left { text-align: left; }
        .total-row { background-color: #eee; font-weight: bold; font-size: 14px; }
        .footer-sign { margin-top: 50px; float: right; text-align: center; width: 250px; }
        
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>LAPORAN TRANSAKSI PERPUSTAKAANKUU</h2>
        <p>Alamat: Jl. Raya Pendidikan No. 123, Indonesia</p>
        <p><b>Periode:</b> <?= date('d/m/Y', strtotime($tgl_mulai)); ?> s/d <?= date('d/m/Y', strtotime($tgl_selesai)); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Tanggal Pinjam</th>
                <th>Nama Anggota</th>
                <th>Judul Buku</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; $total=0; foreach($laporan as $l): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= date('d/m/Y', strtotime($l->tanggal_pinjam)); ?></td>
                <td class="text-left"><?= $l->nama_lengkap; ?></td>
                <td class="text-left"><?= $l->judul; ?></td>
                <td><?= strtoupper($l->status); ?></td>
                <td>Rp <?= number_format($l->denda, 0, ',', '.'); ?></td>
            </tr>
            <?php $total += $l->denda; endforeach; ?>
            
            <?php if(empty($laporan)): ?>
                <tr><td colspan="6">Tidak ada data transaksi pada periode ini.</td></tr>
            <?php endif; ?>

            <tr class="total-row">
                <td colspan="5">TOTAL PENDAPATAN DENDA</td>
                <td>Rp <?= number_format($total, 0, ',', '.'); ?></td>
            </tr>
        </tbody>
    </table>

    <div class="footer-sign">
        <p>Dicetak pada: <?= date('d/m/Y H:i'); ?></p>
        <br><br><br>
        <p><b>_______________________</b></p>
        <p>Admin Perpustakaankuu</p>
    </div>
</body>
</html>