<?= $this->extend('admin/template/index.php') ?>
<?= $this->section('app') ?>
<?php $role = session()->get('role'); ?>

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <h3><?= $title ?? 'Riwayat Pesanan' ?></h3> 
                            <p class="text-subtitle text-muted">Halaman ini menampilkan semua pesanan yang telah selesai (completed).</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Tanggal -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Filter Riwayat Berdasarkan Tanggal</h4>
                        <form action="<?= base_url('admin/orders/riwayat') ?>" method="GET" class="mb-4">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4 col-lg-3">
                                    <label for="start_date" class="form-label">Dari Tanggal:</label>
                                    <input type="text" class="form-control flatpickr" id="start_date" name="start_date" placeholder="Pilih Tanggal Mulai" value="<?= esc($start_date ?? '') ?>">
                                </div>
                                <div class="col-md-4 col-lg-3">
                                    <label for="end_date" class="form-label">Sampai Tanggal:</label>
                                    <input type="text" class="form-control flatpickr" id="end_date" name="end_date" placeholder="Pilih Tanggal Akhir" value="<?= esc($end_date ?? '') ?>">
                                </div>
                                <div class="col-md-4 col-lg-3">
                                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                                    <a href="<?= base_url('admin/orders/riwayat') ?>" class="btn btn-secondary">Reset Filter</a>
                                </div>
                            </div>
                        </form>

                        <!-- Tabel Riwayat -->
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>No Meja</th>
                                        <th>Trx ID</th>
                                        <th>Detail Pesanan</th>
                                        <th>Waktu Pesanan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach ($orders as $order) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= esc($order->nama) ?></td>
                                            <td><?= $order->table_number ?? 'N/A' ?></td>
                                            <td><?= $order->payment->transaction_id ?? 'Belum Dibayar' ?></td>
                                            <td>
                                                <?php if (!empty($order->items)) : ?>
                                                    <ul class="mb-0 ps-3">
                                                        <?php foreach ($order->items as $item) : ?>
                                                            <li><?= esc($item->product_name) ?> (<?= esc($item->quantity) ?>x)</li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php else : ?>
                                                    <span class="text-muted">Tidak ada item</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= date('d-m-Y H:i', strtotime($order->created_at)) ?></td>
                                            <td><span class="badge bg-success">Completed</span></td>
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

<!-- Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr(".flatpickr", {
            dateFormat: "Y-m-d"
        });
    });
</script>

<?= $this->endSection() ?>
