<?= $this->extend('admin/template/index.php') ?>

<?= $this->section('app') ?>

<style>
    table#dataTable th,
    table#dataTable td {
        vertical-align: middle;
        text-align: center;
    }

    .col-no { width: 40px; }
    .col-nama { width: 10px; white-space: normal; word-wrap: break-word; }
    .col-kategori { width: 130px; }
    .col-stok { width: 60px; }
    .col-harga { width: 100px; }
    .col-gambar { width: 70px; }
    .col-status { width: 90px; }
    .col-action { width: 160px; }
</style>

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <h3>Data Produk</h3>
                            <p class="text-subtitle text-muted">Halaman untuk manajemen produk seperti melihat, mengubah, dan menghapus produk.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <?php if (session()->get('role') === 'admin') : ?>
                                <a href="<?= base_url() ?>admin/product/create">
                                    <button type="button" class="btn btn-primary btn-m mb-3">
                                        <i class="bi bi-plus-circle"></i> Tambah Produk 
                                    </button>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="col-no">No</th>
                                            <th class="col-nama">Nama Produk</th>
                                            <th class="col-kategori">Kategori</th>
                                            <th class="col-stok">Stok</th>
                                            <th class="col-harga">Harga</th>
                                            <th class="col-gambar">Gambar</th>
                                            <th class="col-status">Status</th>
                                            <?php if (session()->get('role') === 'admin') : ?>
                                            <th class="col-action">Action</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                <tbody>
                                    <?php foreach ($products as $key => $value) : ?>
                                        <tr>
                                            <td> <?= $key + 1 ?> </td>
                                            <td> <?= $value['name'] ?> </td>
                                            <td> <?= $value['category_nama_category'] ?> </td>
                                            <td>
                                                <?= ($value['stock'] > 0) 
                                                    ? '<span class="badge bg-success">Tersedia</span>' 
                                                    : '<span class="badge bg-danger">Habis</span>' ?>
                                            </td>
                                            <td> <?= number_format($value['price'], 0, ',', '.') ?> </td>
                                            <td> <img src="<?= base_url('uploads/products/'.$value['image']) ?>" alt="<?= $value['name'] ?>" width="50" height="50"> </td>
                                            <td>
                                                <?= is_null($value['deleted_at']) ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Nonaktif</span>' ?>
                                            </td>
                                            <?php if (session()->get('role') === 'admin') : ?>
                                                <td>
                                                    <a href="<?= base_url() ?>admin/product/edit/<?= $value['id'] ?>" class="btn btn-primary btn-sm">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>

                                                    <?php if (is_null($value['deleted_at'])): ?>
                                                    <!-- Produk aktif -->
                                                    <button type="button" class="btn btn-warning btn-sm" onclick="toggleProduct(<?= $value['id'] ?>, 'nonaktif')">
                                                        <i class="bi bi-eye-slash"></i> Nonaktifkan
                                                    </button>
                                                    <?php else: ?>
                                                        <!-- Produk nonaktif -->
                                                        <button type="button" class="btn btn-success btn-sm" onclick="toggleProduct(<?= $value['id'] ?>, 'aktif')">
                                                            <i class="bi bi-eye"></i> Aktifkan
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteProduct(id)
    {
        Swal.fire({
            title: "Apakah anda yakin ingin menghapus produk ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>admin/product/delete/"+id,
                    success: function(result){
                        Swal.fire({
                            allowOutsideClick: false,
                            title: "Deleted!",
                            text: "Produk telah dihapus.",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) location.reload();
                        });
                    },
                    error:function(err){
                        Swal.fire({
                            allowOutsideClick: false,
                            title: "Error!",
                            text: err.responseJSON.message,
                            icon: "warning"
                        });
                    }
                })
            }
        });
    }

    function toggleProduct(id, action) {
        const confirmText = action === 'nonaktif' ? 'menonaktifkan' : 'mengaktifkan';
        const successText = action === 'nonaktif' ? 'dinonaktifkan' : 'diaktifkan';

        Swal.fire({
            title: `Yakin ingin ${confirmText} produk ini?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, lanjutkan",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `<?= base_url('admin/product/toggle') ?>/${id}`,
                    method: "POST",
                    data: { action: action },
                    success: function (res) {
                        Swal.fire("Berhasil!", `Produk berhasil ${successText}.`, "success")
                            .then(() => location.reload());
                    },
                    error: function (err) {
                        Swal.fire("Error", err.responseJSON.message, "error");
                    }
                });
            }
        });
    }

</script>

<?= $this->endSection() ?>
