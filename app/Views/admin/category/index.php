<?= $this->extend('admin/template/index.php') ?>

<?= $this->section('app') ?>

<style>
    table#dataTable th,
    table#dataTable td {
        vertical-align: middle;
        text-align: center;
    }

    .col-no { width: 40px; }
    .col-nama-kategori {
        width: 100px;
        white-space: normal;
        word-wrap: break-word;
    }
    .col-gambar { width: 80px; }
    .col-status { width: 100px; }
    .col-action { width: 160px; }
</style>

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <h3>Data Kategori Produk</h3>
                            <p class="text-subtitle text-muted">Halaman untuk manajemen kategori produk seperti melihat, mengubah, dan menghapus.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <?php if (session()->get('role') === 'admin') : ?>
                                <a href="<?= base_url() ?>admin/category-product/create">
                                    <button type="button" class="btn btn-primary btn-m mb-3">
                                        <i class="bi bi-plus-circle"></i> Tambah Kategori 
                                    </button>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-no">No</th>
                                        <th class="col-nama-kategori">Nama Kategori</th>
                                        <th class="col-gambar">Gambar</th>
                                        <th class="col-status">Status</th>
                                        <?php if (session()->get('role') === 'admin') : ?>
                                            <th class="col-action">Action</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categories as $key => $value) : ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td class="col-nama-kategori"><?= $value['nama_category'] ?></td>
                                            <td>
                                                <?php if (!empty($value['image'])) : ?>
                                                    <img src="<?= base_url('uploads/category/' . $value['image']) ?>" alt="Kategori" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                                <?php else : ?>
                                                    <span class="text-muted">Tidak ada gambar</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= is_null($value['deleted_at']) 
                                                    ? '<span class="badge bg-success">Aktif</span>' 
                                                    : '<span class="badge bg-secondary">Nonaktif</span>' ?>
                                            </td>
                                            <?php if (session()->get('role') === 'admin') : ?>
                                                <td>
                                                    <a href="<?= base_url() ?>admin/category-product/edit/<?= $value['id'] ?>" class="btn btn-primary btn-sm">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <?php if (is_null($value['deleted_at'])): ?>
                                                        <button type="button" class="btn btn-warning btn-sm" onclick="toggleCategory(<?= $value['id'] ?>, 'nonaktif')">
                                                            <i class="bi bi-eye-slash"></i> Nonaktifkan
                                                        </button>
                                                    <?php else: ?>
                                                        <button type="button" class="btn btn-success btn-sm" onclick="toggleCategory(<?= $value['id'] ?>, 'aktif')">
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
    function deleteCategory(id)
    {
        Swal.fire({
            title: "Apakah anda yakin ingin menghapus?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>admin/category-product/delete/"+id,
                    success: function(result){
                        Swal.fire({
                            allowOutsideClick: false,
                            title: "Deleted!",
                            text: "Your category has been deleted.",
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
</script>

<script>
    function toggleCategory(id, action)
    {
        const confirmText = action === 'nonaktif' ? 'menonaktifkan' : 'mengaktifkan';
        const successText = action === 'nonaktif' ? 'dinonaktifkan' : 'diaktifkan kembali';

        Swal.fire({
            title: `Yakin ingin ${confirmText} kategori ini?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, lanjutkan"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/category-product/toggle/') ?>" + id,
                    data: { action: action },
                    success: function(res) {
                        Swal.fire("Berhasil!", `Kategori berhasil ${successText}.`, "success")
                            .then(() => location.reload());
                    },
                    error: function(err) {
                        Swal.fire("Error", err.responseJSON.message, "error");
                    }
                });
            }
        });
    }
</script>


<?= $this->endSection() ?>
