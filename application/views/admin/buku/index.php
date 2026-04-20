<!-- Bagian Konten Utama -->
<div class="main-content" style="margin-left: 250px; padding: 30px;">
    
    <!-- Header Halaman Rata Tengah -->
    <div class="text-center mb-5">
        <h2 class="font-weight-bold text-primary mb-1">
            <span style="font-size: 35px;">📚</span> Koleksi Buku Perpustakaankuu
        </h2>
        <div class="mx-auto" style="width: 80px; height: 3px; background-color: #007bff; border-radius: 10px;"></div>
        <p class="text-muted mt-2">Kelola aset buku perpustakaan Anda dengan mudah dan rapi.</p>
    </div>

    <!-- Baris Fitur: Search & Tambah Buku -->
    <div class="row mb-4">
        <div class="col-md-6">
            <!-- Filter Pencarian Otomatis -->
            <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-0"><i class="fas fa-search text-muted"></i></span>
                </div>
                <input type="text" id="filterBuku" class="form-control border-0" placeholder="Cari judul, penulis, atau penerbit..." style="height: 45px;">
            </div>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-primary font-weight-bold px-4 shadow-sm" style="border-radius: 10px; height: 45px;" data-toggle="modal" data-target="#modalTambahBuku">
                <i class="fas fa-plus-circle mr-2"></i> Tambah Buku
            </button>
        </div>
    </div>

    <!-- Tabel Data Buku -->
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-center align-middle" id="tabelBuku">
                    <thead class="bg-light">
                        <tr class="text-dark">
                            <th class="py-3 border-0">No</th>
                            <th class="py-3 border-0">Cover</th>
                            <th class="py-3 border-0">Judul</th>
                            <th class="py-3 border-0">Penulis</th>
                            <th class="py-3 border-0">Penerbit</th> <!-- Kolom Baru -->
                            <th class="py-3 border-0">Katalog</th>
                            <th class="py-3 border-0">Stok</th>
                            <th class="py-3 border-0">Status</th>
                            <th class="py-3 border-0">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($buku)): ?>
                            <?php $no=1; foreach($buku as $b): ?>
                            <tr>
                                <td class="py-3"><?= $no++; ?></td>
                                <td class="py-2">
                                    <img src="<?= base_url('assets/img/cover/'.$b->cover); ?>" width="55" height="75" class="rounded shadow-sm" style="object-fit: cover;">
                                </td>
                                <td class="py-3 font-weight-bold text-left"><?= $b->judul; ?></td>
                                <td class="py-3"><?= $b->penulis; ?></td>
                                <td class="py-3 text-muted"><?= $b->penerbit; ?></td> <!-- Isi Data Penerbit -->
                                <td class="py-3">
                                    <span class="badge badge-info px-3 py-2" style="border-radius: 8px;">
                                        <?= $b->kategori; ?>
                                    </span>
                                </td>
                                <td class="py-3 font-weight-bold"><?= $b->stok; ?></td>
                                <td class="py-3">
                                    <?php if($b->stok > 0): ?>
                                        <span class="text-success small font-weight-bold"><i class="fas fa-check-circle mr-1"></i> Tersedia</span>
                                    <?php else: ?>
                                        <span class="text-danger small font-weight-bold"><i class="fas fa-times-circle mr-1"></i> Habis</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3">
                                    <button class="btn btn-sm btn-warning text-white mr-1 shadow-sm" data-toggle="modal" data-target="#modalEditBuku<?= $b->id_buku; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="<?= base_url('index.php/buku/hapus/'.$b->id_buku); ?>" class="btn btn-sm btn-danger shadow-sm" onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>

                            <!-- MODAL EDIT BUKU -->
                            <div class="modal fade" id="modalEditBuku<?= $b->id_buku; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content" style="border-radius: 20px; border: none;">
                                        <div class="modal-header border-0 bg-warning text-white" style="border-radius: 20px 20px 0 0; padding: 25px;">
                                            <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i> Edit Data Buku</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                        </div>
                                        <form action="<?= base_url('index.php/buku/update'); ?>" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="id_buku" value="<?= $b->id_buku; ?>">
                                            <div class="modal-body p-4 text-left">
                                                <div class="row">
                                                    <div class="col-md-6 border-right">
                                                        <div class="form-group mb-3">
                                                            <label class="font-weight-bold text-dark small">JUDUL BUKU</label>
                                                            <input type="text" name="judul" class="form-control" value="<?= $b->judul; ?>" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="font-weight-bold text-dark small">PENULIS</label>
                                                            <input type="text" name="penulis" class="form-control" value="<?= $b->penulis; ?>" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="font-weight-bold text-dark small">GANTI COVER</label>
                                                            <input type="file" name="cover" class="form-control-file border p-1 rounded shadow-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label class="font-weight-bold text-dark small">KATALOG</label>
                                                            <select name="kategori" class="form-control" required>
                                                                <option value="Sejarah" <?= ($b->kategori == 'Sejarah') ? 'selected' : ''; ?>>Sejarah</option>
                                                                <option value="Teknologi" <?= ($b->kategori == 'Teknologi') ? 'selected' : ''; ?>>Teknologi</option>
                                                                <option value="Novel" <?= ($b->kategori == 'Novel') ? 'selected' : ''; ?>>Novel</option>
                                                                <option value="Edukasi" <?= ($b->kategori == 'Edukasi') ? 'selected' : ''; ?>>Edukasi</option>
                                                                <option value="Agama" <?= ($b->kategori == 'Agama') ? 'selected' : ''; ?>>Agama</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="font-weight-bold text-dark small">PENERBIT</label>
                                                            <input type="text" name="penerbit" class="form-control" value="<?= $b->penerbit; ?>" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="font-weight-bold text-dark small">STOK</label>
                                                            <input type="number" name="stok" class="form-control" value="<?= $b->stok; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 p-4">
                                                <button type="button" class="btn btn-light px-4 font-weight-bold" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-warning text-white px-4 font-weight-bold shadow-sm">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="9" class="text-center py-5 text-muted">Belum ada data buku.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH BUKU -->
<div class="modal fade" id="modalTambahBuku" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header border-0 bg-primary text-white" style="border-radius: 20px 20px 0 0; padding: 25px;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-book-medical mr-2"></i> Tambah Koleksi Buku</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            
            <form action="<?= base_url('index.php/buku/simpan'); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4 text-left">
                    <div class="row">
                        <div class="col-md-6 border-right">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-dark small">JUDUL BUKU</label>
                                <input type="text" name="judul" class="form-control border-light shadow-sm" placeholder="Masukkan judul" required style="border-radius: 10px;">
                            </div>
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-dark small">PENULIS</label>
                                <input type="text" name="penulis" class="form-control border-light shadow-sm" placeholder="Nama penulis" required style="border-radius: 10px;">
                            </div>
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-dark small">COVER BUKU</label>
                                <input type="file" name="cover" class="form-control-file border p-1 rounded shadow-sm">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-dark small">KATALOG</label>
                                <select name="kategori" class="form-control border-light shadow-sm" required style="border-radius: 10px;">
                                    <option value="">-- Pilih Katalog --</option>
                                    <option value="Sejarah">Sejarah</option>
                                    <option value="Teknologi">Teknologi</option>
                                    <option value="Novel">Novel</option>
                                    <option value="Edukasi">Edukasi</option>
                                    <option value="Agama">Agama</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-dark small">PENERBIT</label>
                                <input type="text" name="penerbit" class="form-control border-light shadow-sm" placeholder="Nama penerbit" required style="border-radius: 10px;">
                            </div>
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-dark small">STOK AWAL</label>
                                <input type="number" name="stok" class="form-control border-light shadow-sm" required style="border-radius: 10px;">
                            </div>
                            <!-- Input Tahun Terbit -->
                            <input type="hidden" name="tahun_terbit" value="<?= date('Y'); ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-light px-4 font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm font-weight-bold" style="border-radius: 10px;">Simpan Buku</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPT FILTER PENCARIAN OTOMATIS -->
<script>
    document.getElementById('filterBuku').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tabelBuku tbody tr');

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            if (text.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>