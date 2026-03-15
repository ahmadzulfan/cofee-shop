<?= $this->extend('admin/template/index.php') ?>

<?= $this->section('app') ?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tambah Meja</h4>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/tables/store') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="table_number">Nomor Meja</label>
                            <input type="text" class="form-control" name="table_number" required>
                        </div>
                        <!-- <div class="form-group mt-3">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="available">Tersedia</option>
                                <option value="occupied">Terpakai</option>
                                <option value="reserved">Dipesan</option>
                            </select>
                        </div> -->
                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
