<?= $this->extend('admin/template/index.php') ?>

<?= $this->section('app') ?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h3>Daftar Meja</h3>
                    <div class="d-flex justify-content-end">
                        <?php if (session()->get('role') === 'admin') : ?>
                            <a href="<?= base_url() ?>admin/tables/create">
                                <button type="button" class="btn btn-primary btn-m mb-3">
                                    <i class="bi bi-plus-circle"></i> Tambah Meja 
                                </button>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Meja</th>
                                    <!-- <th>Status</th> -->
                                    <?php if (session()->get('role') === 'admin') : ?>
                                            <th class="col-action">Action</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tables as $key => $table) : ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $table['table_number'] ?></td>
                                        <!-- <td><?= ucfirst($table['status']) ?></td> -->
                                        <?php if (session()->get('role') === 'admin') : ?>
                                            <td>
                                                <a href="<?= base_url('admin/tables/edit/' . $table['id']) ?>" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <button onclick="deleteTable(<?= $table['id'] ?>)" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                                <a  onclick="showQr('<?= base_url('api/get/qr/' . $table['table_number']) ?>')" class="btn btn-secondary btn-sm">
                                                    <i class="bi bi-qr-code"></i> QR
                                                </a>
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
<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header">
        <h5 class="modal-title" id="qrModalLabel">QR Code Meja</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <img id="qrImage" src="" alt="QR Code" class="img-fluid">
      </div>
    </div>
  </div>
</div>
<script>
    function deleteTable(id) {
        Swal.fire({
            title: "Apakah Anda yakin ingin menghapus meja ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('admin/tables/delete/') ?>" + id;
            }
        });
    }
</script>
<script>
function showQr(qrUrl) {
  document.getElementById('qrImage').src = qrUrl;
  const qrModal = new bootstrap.Modal(document.getElementById('qrModal'));
  qrModal.show();
}
</script>


<?= $this->endSection() ?>
