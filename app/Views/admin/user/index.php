<?= $this->extend('admin/template/index.php') ?>

<?= $this->section('app') ?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h3>Manajemen Pengguna</h3>
                    <div class="d-flex justify-content-end">
                        <a href="<?= base_url() ?>admin/users/create">
                            <button type="button" class="btn btn-primary btn-m mb-3">
                                <i class="bi bi-plus-circle"></i> Tambah Pengguna 
                            </button>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Telepon</th>
                                    <th>Alamat</th>
                                    <th>Role</th>
                                    <th>Terdaftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $key => $user) : ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= esc($user->name) ?></td>
                                        <td><?= esc($user->email) ?></td>
                                        <td><?= esc($user->phone) ?></td>
                                        <td><?= esc($user->address) ?></td>
                                        <td><?= ucfirst($user->role) ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($user->created_at)) ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/users/edit/' . $user->id) ?>" class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button onclick="deleteUser(<?= $user->id ?>)" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </td>
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

<script>
    function deleteUser(id) {
        Swal.fire({
            title: "Apakah Anda yakin ingin menghapus pengguna ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('admin/users/delete/') ?>" + id;
            }
        });
    }
</script>

<?= $this->endSection() ?>
