<div class="main-content" style="margin-left: 250px; padding: 30px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="font-weight-bold text-primary mb-1">
                <span style="font-size: 35px;">🔄</span> Transaksi Peminjaman
            </h2>
            <div style="width: 80px; height: 3px; background-color: #007bff; border-radius: 10px;"></div>
        </div>
        <a href="<?= base_url('index.php/transaksi/cetak'); ?>" target="_blank" class="btn btn-danger shadow-sm px-4" style="border-radius: 10px;">
            <i class="fas fa-print mr-2"></i> Cetak Laporan
        </a>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 text-center">
                <thead class="bg-light text-dark">
                    <tr>
                        <th class="py-3">ID Transaksi</th>
                        <th class="py-3">Peminjam</th>
                        <th class="py-3">Judul Buku</th>
                        <th class="py-3">Tgl Pinjam</th>
                        <th class="py-3">Denda</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($transaksi as $t): ?>
                    <tr>
                        <td class="py-3 font-weight-bold text-primary">TRX-<?= $t->id_transaksi; ?></td>
                        <td class="text-left"><?= $t->nama_peminjam; ?></td>
                        <td class="text-left small"><?= $t->judul_buku; ?></td>
                        <td><?= date('d M Y', strtotime($t->tanggal_pinjam)); ?></td>
                        <td>
                            <?= ($t->denda > 0) ? '<span class="text-danger font-weight-bold">Rp '.number_format($t->denda, 0, ',', '.').'</span>' : '<span class="text-muted small">-</span>'; ?>
                        </td>
                        <td>
                            <span class="badge <?= ($t->status == 'dipinjam') ? 'badge-warning' : 'badge-success'; ?> px-3 py-2 text-uppercase" style="font-size: 10px; border-radius: 8px;">
                                <?= $t->status; ?>
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info shadow-sm btn-detail" 
                                    data-id="<?= $t->id_transaksi; ?>" 
                                    data-toggle="modal" 
                                    data-target="#modalDetail" 
                                    style="border-radius: 8px;">
                                <i class="fas fa-eye mr-1"></i> Detail
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL DETAIL TRANSAKSI -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header bg-primary text-white" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-info-circle mr-2"></i> Detail Peminjaman</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="badge badge-primary px-4 py-2 mb-4" id="view-id" style="font-size: 16px; border-radius: 10px;">ID: TRX-0</div>
                <div class="text-left">
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Nama Peminjam</div>
                        <div class="col-7 font-weight-bold" id="view-nama">-</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Judul Buku</div>
                        <div class="col-7 font-weight-bold" id="view-judul">-</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Tanggal Pinjam</div>
                        <div class="col-7" id="view-tgl">-</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Status</div>
                        <div class="col-7"><span id="view-status" class="badge px-3 py-2">-</span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Denda Terakumulasi</div>
                        <div class="col-7 text-danger font-weight-bold" id="view-denda">Rp 0</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border: none;">
                <button type="button" class="btn btn-light" data-dismiss="modal" style="border-radius: 10px;">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT JAVASCRIPT AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.btn-detail').on('click', function() {
        var id = $(this).data('id');
        
        // Reset tampilan modal ke state loading
        $('#view-id').text('Memuat...');
        $('#view-nama').text('-');
        $('#view-judul').text('-');
        $('#view-tgl').text('-');
        $('#view-denda').text('Rp 0');
        
        $.ajax({
            // Menggunakan site_url agar path ke controller tepat
            url: "<?= site_url('transaksi/detail_ajax/'); ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                if(data) {
                    // Pastikan variabel data sesuai dengan select di Controller
                    $('#view-id').text('ID: TRX-' + data.id_transaksi);
                    $('#view-nama').text(data.nama_lengkap);
                    $('#view-judul').text(data.judul_buku);
                    $('#view-tgl').text(data.tanggal_pinjam);
                    
                    // Format Denda ke Rupiah
                    var formattedDenda = new Intl.NumberFormat('id-ID').format(data.denda);
                    $('#view-denda').text('Rp ' + formattedDenda);
                    
                    // Pengaturan Badge Status
                    if(data.status == 'dipinjam') {
                        $('#view-status').text('DIPINJAM').addClass('badge-warning').removeClass('badge-success text-white');
                    } else {
                        $('#view-status').text('KEMBALI').addClass('badge-success text-white').removeClass('badge-warning');
                    }
                }
            },
            error: function() {
                alert('Gagal mengambil data dari server. Cek koneksi database atau URL.');
            }
        });
    });
});
</script>