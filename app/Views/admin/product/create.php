<?= $this->extend('admin/template/index.php') ?>

<?= $this->section('app') ?>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Input Produk Baru</h4>
                    <p class="card-description">Harap mengisikan data produk dengan lengkap</p>
                    <form action="<?= base_url('admin/product/store') ?>" method="post" class="forms-sample" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <!-- Nama Produk -->
                        <div class="form-group">
                            <label for="name">Nama Produk</label>
                            <input type="text" class="form-control" name="name" placeholder="Nama Produk" value="<?= old('name') ?>" required>
                            <small class="text-danger"><?= !empty(session()->getFlashdata('validation')['name']) ? session()->getFlashdata('validation')['name'] : '' ?></small>
                        </div>

                        <!-- Kategori Produk -->
                        <div class="form-group">
                            <label for="category_id">Kategori</label>
                            <select class="form-control" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?= $category['id'] ?>" <?= old('category_id') == $category['id'] ? 'selected' : '' ?>>
                                        <?= $category['nama_category'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-danger"><?= !empty(session()->getFlashdata('validation')['category_id']) ? session()->getFlashdata('validation')['category_id'] : '' ?></small>
                        </div>

                        <!-- Stok -->
                        <div class="form-group">
                            <label for="stock">Stok</label>
                            <input type="number" class="form-control" name="stock" placeholder="Stok Produk" value="<?= old('stock') ?>" required>
                            <small class="text-danger"><?= !empty(session()->getFlashdata('validation')['stock']) ? session()->getFlashdata('validation')['stock'] : '' ?></small>
                        </div>

                        <!-- Harga -->
                        <div class="form-group">
                            <label for="price">Harga</label>
                            <input type="number" class="form-control" name="price" placeholder="Harga Produk" value="<?= old('price') ?>" required>
                            <small class="text-danger"><?= !empty(session()->getFlashdata('validation')['price']) ? session()->getFlashdata('validation')['price'] : '' ?></small>
                        </div>

                        <!-- Deskripsi -->
                        <div class="form-group">
                            <label for="description">Deskripsi Produk</label>
                            <textarea name="description" class="form-control" placeholder="Masukan deskripsi produk"><?= old('description') ?></textarea>
                            <small class="text-danger"><?= !empty(session()->getFlashdata('validation')['description']) ? session()->getFlashdata('validation')['description'] : '' ?></small>
                        </div>

                        <!-- Gambar Produk -->
                        <div class="form-group">
                            <label for="image">Gambar Produk</label>
                            <input type="file" class="form-control" name="image" required>
                            <small class="text-danger"><?= !empty(session()->getFlashdata('validation')['image']) ? session()->getFlashdata('validation')['image'] : '' ?></small>
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
