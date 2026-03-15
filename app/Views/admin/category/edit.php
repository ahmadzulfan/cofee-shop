<?= $this->extend('admin/template/index.php') ?>

<?= $this->section('app') ?>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Edit Kategori</h4>
                    <p class="card-description">Harap mengisikan data kategori yang ingin diubah</p>
                    <!-- Tambahkan enctype="multipart/form-data" untuk upload file -->
                    <!-- Pastikan action mengarah ke method update di controller Anda, contoh: update/{id} -->
                    <form method="post" action="<?= base_url('admin/category-product/update/' . $category['id']) ?>" class="forms-sample" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <!-- Nama Kategori -->
                        <div class="form-group">
                            <label for="nama_category">Nama Kategori</label>
                            <input type="text" class="form-control" name="nama_category" placeholder="Nama Kategori" value="<?= old('nama_category', $category['nama_category']) ?>" required>
                            <small class="text-danger"><?= !empty(session()->getFlashdata('validation')['nama_category']) ? session()->getFlashdata('validation')['nama_category'] : '' ?></small>
                        </div>

                        <!-- Input untuk Upload Gambar -->
                        <div class="form-group">
                            <label for="image">Gambar Kategori</label>
                            <!-- Tampilkan gambar yang sudah ada jika ada -->
                            <?php if (!empty($category['image'])) : ?>
                                <div class="mb-2">
                                    <img src="<?= base_url('uploads/category/' . $category['image']) ?>" alt="Current Image" style="max-width: 150px; height: auto; border-radius: 8px;">
                                    <p class="text-muted mt-1">Gambar saat ini</p>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Hidden input untuk menyimpan nama gambar lama -->
                            <input type="hidden" name="old_image" value="<?= $category['image'] ?? '' ?>">

                            <input type="file" class="form-control" name="image" id="image">
                            <small class="text-danger"><?= !empty(session()->getFlashdata('validation')['image']) ? session()->getFlashdata('validation')['image'] : '' ?></small>
                            <small class="form-text text-muted">Unggah gambar baru untuk mengganti gambar saat ini (maks. 2MB, format JPG/PNG). Biarkan kosong jika tidak ingin mengubah gambar.</small>
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
