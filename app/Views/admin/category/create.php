<?= $this->extend('admin/template/index.php') ?>

<?= $this->section('app') ?>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Input Kategori Baru</h4>
                    <p class="card-description">Harap mengisikan data kategori produk dengan benar</p>
                    <!-- Tambahkan enctype="multipart/form-data" untuk upload file -->
                    <form method="post" action="<?= base_url('admin/category-product/store') ?>" class="forms-sample" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <!-- Nama Kategori -->
                        <div class="form-group">
                            <label for="nama_category">Nama Kategori</label>
                            <input type="text" class="form-control" name="nama_category" placeholder="Nama Kategori" value="<?= old('nama_category') ?>" required>
                            <small class="text-danger"><?= !empty(session()->getFlashdata('validation')['nama_category']) ? session()->getFlashdata('validation')['nama_category'] : '' ?></small>
                        </div>

                        <!-- Input untuk Upload Gambar -->
                        <div class="form-group">
                            <label for="image">Gambar Kategori</label>
                            <input type="file" class="form-control" name="image" id="image">
                            <small class="text-danger"><?= !empty(session()->getFlashdata('validation')['image']) ? session()->getFlashdata('validation')['image'] : '' ?></small>
                            <small class="form-text text-muted">Unggah gambar untuk kategori (maks. 2MB, format JPG/PNG).</small>
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
