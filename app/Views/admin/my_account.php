<?= $this->extend('admin/template/index.php') ?>

<?= $this->section('app') ?>

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 col-lg-12">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <h3>Akun Saya</h3>
                            <p class="text-subtitle text-muted">Halaman untuk melihat dan mengelola informasi akun admin.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th width="200">Nama Lengkap</th>
                                        <td><?= esc($user->name) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?= esc($user->email) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Role</th>
                                        <td><?= esc($user->role) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Bergabung Sejak</th>
                                        <td><?= date('d F Y', strtotime($user->created_at)) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <a href="#" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalUbahPassword">
                                <i class="bi bi-key-fill"></i> Ubah Password
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Ubah Password -->
<div class="modal fade" id="modalUbahPassword" tabindex="-1" aria-labelledby="ubahPasswordLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="<?= site_url('admin/my-account/ubah-password') ?>" method="post">
        <?= csrf_field() ?>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahPasswordLabel">Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Password Lama</label>
                    <input type="password" name="old_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password Baru</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </form>
  </div>
</div>


<?= $this->endSection() ?>
