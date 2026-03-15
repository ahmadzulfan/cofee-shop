<?= $this->extend('admin/template/index.php') ?>

<?= $this->section('app') ?>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Produk</h4>
                    <p class="card-description">Harap mengubah data sesuai format</p>
                    <form method="post" action="<?= base_url('admin/product/update/' . $product['id']) ?>" enctype="multipart/form-data" class="forms-sample">
                        <?= csrf_field() ?>

                        <!-- Nama Produk -->
                        <div class="form-group">
                            <label for="name">Nama Produk</label>
                            <input type="text" class="form-control" name="name" value="<?= old('name', $product['name']) ?>" required>
                            <small class="text-danger"><?= session()->getFlashdata('validation')['name'] ?? '' ?></small>
                        </div>

                        <!-- Kategori Produk -->
                        <div class="form-group">
                            <label for="category_id">Kategori</label>
                            <select class="form-control" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?= $category['id'] ?>" <?= ($product['category_id'] == $category['id']) ? 'selected' : '' ?>><?= $category['nama_category'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-danger"><?= session()->getFlashdata('validation')['category_id'] ?? '' ?></small>
                        </div>

                        <!-- Harga Produk -->
                        <div class="form-group">
                            <label for="price">Harga</label>
                            <input type="text" class="form-control" name="price" 
                                value="<?= old('price', number_format($product['price'], 0, ',', '.')) ?>" 
                                required>   <!-- desimal -->
                            <small class="text-danger"><?= session()->getFlashdata('validation')['price'] ?? '' ?></small>
                        </div>

                        <!-- Stok Produk -->
                        <div class="form-group">
                            <label for="stock">Stok</label>
                            <input type="number" class="form-control" name="stock" value="<?= old('stock', $product['stock']) ?>" required>
                            <small class="text-danger"><?= session()->getFlashdata('validation')['stock'] ?? '' ?></small>
                        </div>

                        <!-- Deskripsi -->
                        <div class="form-group">
                            <label for="description">Deskripsi Produk</label>
                            <textarea name="description" class="form-control" placeholder="Masukan deskripsi produk"><?= old('description', $product['description']) ?></textarea>
                            <small class="text-danger"><?= !empty(session()->getFlashdata('validation')['description']) ? session()->getFlashdata('validation')['description'] : '' ?></small>
                        </div>

                        <!-- Gambar Produk -->
                        <div class="form-group">
                            <label for="image">Gambar Produk</label>
                            <input type="file" class="form-control" name="image">
                            <?php if ($product['image']) : ?>
                                <img src="<?= base_url('uploads/products/' . $product['image']) ?>" alt="Gambar Produk" width="100">
                            <?php endif; ?>
                            <small class="text-danger"><?= session()->getFlashdata('validation')['image'] ?? '' ?></small>
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                        <a href="<?= base_url('admin/products') ?>" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
