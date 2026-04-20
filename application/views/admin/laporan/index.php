<div class="main-content" style="margin-left: 250px; padding: 30px;">
    <h2 class="font-weight-bold text-primary mb-4"><i class="fas fa-file-alt mr-2"></i> Rekapitulasi Laporan</h2>

    <!-- Card Statistik -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 bg-primary text-white" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Koleksi Buku</div>
                            <div class="h5 mb-0 font-weight-bold"><?= $total_buku; ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-book fa-2x opacity-50"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 bg-success text-white" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Anggota Aktif</div>
                            <div class="h5 mb-0 font-weight-bold"><?= $total_anggota; ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-user-graduate fa-2x opacity-50"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 bg-warning text-white" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Sedang Dipinjam</div>
                            <div class="h5 mb-0 font-weight-bold"><?= $total_pinjam; ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-exchange-alt fa-2x opacity-50"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2 bg-danger text-white" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Kas Denda</div>
                            <div class="h5 mb-0 font-weight-bold">Rp <?= number_format($total_denda, 0, ',', '.'); ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-wallet fa-2x opacity-50"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card shadow-sm mb-4" style="border-radius: 15px;">
        <div class="card-body">
            <form action="<?= base_url('index.php/laporan'); ?>" method="get">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label class="font-weight-bold small text-muted">TANGGAL MULAI</label>
                        <input type="date" name="tgl_mulai" class="form-control" value="<?= $tgl_mulai; ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold small text-muted">TANGGAL SELESAI</label>
                        <input type="date" name="tgl_selesai" class="form-control" value="<?= $tgl_selesai; ?>" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary px-4"><i class="fas fa-filter mr-2"></i> Filter Data</button>
                        <?php if($tgl_mulai): ?>
                            <a href="<?= base_url('index.php/laporan/cetak_pdf?tgl_mulai='.$tgl_mulai.'&tgl_selesai='.$tgl_selesai); ?>" target="_blank" class="btn btn-danger px-4"><i class="fas fa-file-pdf mr-2"></i> Cetak PDF</a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Hasil Laporan -->
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light text-center">
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
                        <?php if(empty($laporan)): ?>
                            <tr><td colspan="6" class="text-center py-5 text-muted">Silakan pilih rentang tanggal untuk menampilkan data.</td></tr>
                        <?php else: $no=1; foreach($laporan as $l): ?>
                            <tr class="text-center">
                                <td><?= $no++; ?></td>
                                <td><?= date('d/m/Y', strtotime($l->tanggal_pinjam)); ?></td>
                                <td class="text-left font-weight-bold"><?= $l->nama_lengkap; ?></td>
                                <td class="text-left italic"><?= $l->judul; ?></td>
                                <td>
                                    <span class="badge badge-pill badge-<?= $l->status == 'dipinjam' ? 'warning text-dark' : 'success'; ?> px-3">
                                        <?= strtoupper($l->status); ?>
                                    </span>
                                </td>
                                <td class="text-danger font-weight-bold">Rp <?= number_format($l->denda, 0, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>