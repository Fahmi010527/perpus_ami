<div class="main-content" style="margin-left: 250px; padding: 30px;">
    <!-- Menampilkan Notifikasi (Pesan Berhasil/Gagal) -->
    <?= $this->session->flashdata('pesan'); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-weight-bold text-primary"><i class="fas fa-users mr-2"></i> Data Anggota</h2>
        <!-- Tombol memicu Modal Tambah -->
        <button class="btn btn-primary shadow-sm px-4" data-toggle="modal" data-target="#modalTambah" style="border-radius: 10px;">
            <i class="fas fa-plus mr-2"></i> Tambah Anggota
        </button>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="bg-light text-center">
                    <tr>
                        <th class="py-3">No</th>
                        <th class="py-3">Foto</th>
                        <th class="py-3">Nama Lengkap</th>
                        <th class="py-3">Kelas</th>
                        <th class="py-3">Username</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($anggota as $a): ?>
                    <tr class="text-center">
                        <td class="align-middle"><?= $no++; ?></td>
                        <td class="align-middle">
                            <img src="<?= $a->foto ? base_url('assets/img/profile/').$a->foto : 'https://ui-avatars.com/api/?name='.urlencode($a->nama_lengkap); ?>" width="45" height="45" class="rounded-circle shadow-sm" style="object-fit: cover; border: 2px solid #e3e6f0;">
                        </td>
                        <td class="text-left align-middle font-weight-bold"><?= $a->nama_lengkap; ?></td>
                        <td class="align-middle"><span class="badge badge-info px-3 py-2" style="border-radius: 8px;"><?= $a->kelas; ?></span></td>
                        <td class="align-middle"><?= $a->username; ?></td>
                        <td class="align-middle">
                            <!-- Tombol Cetak Kartu -->
                            <a href="<?= base_url('index.php/anggota/kartu/'.$a->id); ?>" target="_blank" class="btn btn-sm btn-info rounded-circle text-white shadow-sm" title="Cetak Kartu">
                                <i class="fas fa-id-card"></i>
                            </a>
                            <!-- Tombol Edit memicu Modal Edit -->
                            <button class="btn btn-sm btn-warning rounded-circle text-white shadow-sm" data-toggle="modal" data-target="#modalEdit<?= $a->id; ?>" title="Edit Data">
                                <i class="fas fa-edit"></i>
                            </button>
                            <!-- Tombol Hapus -->
                            <a href="<?= base_url('index.php/anggota/hapus/'.$a->id); ?>" class="btn btn-sm btn-danger rounded-circle shadow-sm" onclick="return confirm('Yakin ingin menghapus anggota ini?')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- MODAL EDIT DATA -->
                    <div class="modal fade" id="modalEdit<?= $a->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content" style="border-radius: 15px;">
                                <div class="modal-header border-0">
                                    <h5 class="modal-title font-weight-bold"><i class="fas fa-user-edit mr-2 text-warning"></i>Edit Anggota</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <!-- Tambahkan enctype="multipart/form-data" untuk upload foto -->
                                <form action="<?= base_url('index.php/anggota/edit'); ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?= $a->id; ?>">
                                    <div class="modal-body">
                                        <div class="form-group text-center mb-3">
                                            <img src="<?= $a->foto ? base_url('assets/img/profile/').$a->foto : 'https://ui-avatars.com/api/?name='.urlencode($a->nama_lengkap); ?>" width="80" height="80" class="rounded-circle shadow-sm mb-2" style="object-fit: cover;">
                                            <p class="small text-muted">Foto profil saat ini</p>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold">Ganti Foto Profil</label>
                                            <input type="file" name="foto" class="form-control-file">
                                            <small class="text-danger">*Format: JPG/PNG, Maks: 2MB</small>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold">Nama Lengkap</label>
                                            <input type="text" name="nama_lengkap" class="form-control" value="<?= $a->nama_lengkap; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold">Username</label>
                                            <input type="text" name="username" class="form-control" value="<?= $a->username; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold">Kelas</label>
                                            <input type="text" name="kelas" class="form-control" value="<?= $a->kelas; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold">Ganti Password</label>
                                            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin ganti password">
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-light px-4" data-dismiss="modal" style="border-radius: 10px;">Batal</button>
                                        <button type="submit" class="btn btn-primary px-4" style="border-radius: 10px;">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH DATA -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0">
                <h5 class="modal-title font-weight-bold text-primary"><i class="fas fa-user-plus mr-2"></i>Tambah Anggota Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('index.php/anggota/tambah'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Foto Profil</label>
                        <input type="file" name="foto" class="form-control-file">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama siswa..." required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Username (Email)</label>
                        <input type="text" name="username" class="form-control" placeholder="contoh@gmail.com" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Kelas</label>
                        <input type="text" name="kelas" class="form-control" placeholder="Contoh: XII PPLG 1">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light px-4" data-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="submit" class="btn btn-primary px-4" style="border-radius: 10px;">Daftarkan Anggota</button>
                </div>
            </form>
        </div>
    </div>
</div>