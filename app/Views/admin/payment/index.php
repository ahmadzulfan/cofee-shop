<?= $this->extend('admin/template/index.php') ?>

<?= $this->section('app') ?>

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <h3>Data Pesanan Produk</h3>
                            <p class="text-subtitle text-muted">Halaman untuk manajemen pesanan produk.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table">
                                <thead>
                                    <tr>
                                        <th> No </th>
                                        <th> Trx ID </th>
                                        <th> Payment Method </th>
                                        <th> Payment Status </th>
                                        <th> Total Payment </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($payments as $key => $payment) : ?>
                                        <tr>
                                            <td> <?= $key + 1 ?> </td>
                                            <td> <?= $payment->transaction_id ?> </td>
                                            <td> <?= $payment->payment_method ?> </td>
                                            <td> <?= $payment->payment_status ?> </td>
                                            <td> Rp <?= number_format(10000, 0, '.', '.') ?> </td>
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

<?= $this->endSection() ?>
