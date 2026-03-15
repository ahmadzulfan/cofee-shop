<?= $this->extend('admin/template/index.php') ?>

<?= $this->section('app') ?>

<?php $role = $role ?? ''; ?>

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <h3>Data Review Produk</h3>
                            <p class="text-subtitle text-muted">Halaman untuk manajemen review produk seperti melihat, mengubah, dan menghapus.</p>
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
                                        <th> Nama </th>
                                        <th> Review </th>
                                        <?php if ($role === 'pemilik') : ?>
                                        <th> Action </th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reviews as $key => $review) : ?>
                                        <tr>
                                            <td> <?= $key + 1 ?> </td>
                                            <td> <?= $review->nama ?> </td>
                                            <td> <?= $review->comment ?> </td>
                                            <?php if ($role === 'pemilik') : ?>
                                            <td> 
                                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteCategory(<?= $review->id ?>)"> 
                                                    <i class="bi bi-trash-fill"></i>
                                                </button> 
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
                    url: "<?= base_url() ?>admin/reviews/delete/"+id,
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
