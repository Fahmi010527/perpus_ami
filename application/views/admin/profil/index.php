<div class="main-content" style="margin-left: 250px; padding: 30px;">
    <!-- Menampilkan pesan sukses/error -->
    <?= $this->session->flashdata('pesan'); ?>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0" style="border-radius: 20px; overflow: hidden;">
                <div class="bg-primary py-5 text-center">
                    <div class="bg-white rounded-circle d-inline-block p-2 shadow-sm mb-3" style="width: 120px; height: 120px;">
                        <?php 
                        $foto = $user->foto ? base_url('assets/img/profile/').$user->foto : 'https://ui-avatars.com/api/?name='.$user->nama_lengkap;
                        ?>
                        <img src="<?= $foto; ?>" class="rounded-circle w-100 h-100" style="object-fit: cover;">
                    </div>
                    <h4 class="text-white font-weight-bold mb-0"><?= $user->nama_lengkap; ?></h4>
                    <span class="badge badge-light text-primary text-uppercase"><?= $user->role; ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="form-group text-center">
                        <label class="small font-weight-bold text-muted">USERNAME / EMAIL</label>
                        <p class="h6"><?= $user->username; ?></p>
                    </div>
                    <hr>
                    <div class="form-group text-center mt-4">
                        <button class="btn btn-primary px-4 shadow-sm" style="border-radius: 10px;" data-toggle="modal" data-target="#modalEdit">
                            <i class="fas fa-user-edit mr-2"></i> Edit Profil
                        </button>
                        <button class="btn btn-outline-danger px-4 ml-2" style="border-radius: 10px;" data-toggle="modal" data-target="#modalPassword">
                            <i class="fas fa-key mr-2"></i> Ganti Password
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT PROFIL -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0">
                <h5 class="modal-title font-weight-bold">Update Profil</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?= base_url('index.php/profil/update'); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $user->id; ?>">
                <div class="modal-body p-4">
                    <div class="form-group">
                        <label class="font-weight-bold small">NAMA LENGKAP</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="<?= $user->nama_lengkap; ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold small">USERNAME</label>
                        <input type="text" name="username" class="form-control" value="<?= $user->username; ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold small">FOTO BARU (Opsional)</label>
                        <input type="file" name="foto" class="form-control-file border p-2 rounded">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary btn-block shadow">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PASSWORD -->
<div class="modal fade" id="modalPassword" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0">
                <h5 class="modal-title font-weight-bold text-danger">Ganti Password</h5>
            </div>
            <form action="<?= base_url('index.php/profil/ganti_password'); ?>" method="POST">
                <input type="hidden" name="id" value="<?= $user->id; ?>">
                <div class="modal-body">
                    <input type="password" name="password" class="form-control text-center" placeholder="Password Baru" required>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-danger btn-block">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>