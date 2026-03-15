<?= $this->extend('admin/template/index.php') ?>

<?= $this->section('app') ?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Meja</h4>
                    <form action="<?= base_url('admin/tables/update/' . $table['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="table_number">Nomor Meja</label>
                            <input type="text" class="form-control" name="table_number" value="<?= $table['table_number'] ?>" required>
                        </div>
                        <!-- <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="available" <?= $table['status'] == 'available' ? 'selected' : '' ?>>Tersedia</option>
                                <option value="occupied" <?= $table['status'] == 'occupied' ? 'selected' : '' ?>>Terpakai</option>
                                <option value="reserved" <?= $table['status'] == 'reserved' ? 'selected' : '' ?>>Dipesan</option>
                            </select>
                        </div> -->
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
