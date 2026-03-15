<?= $this->extend('admin/template/index.php') ?>
<?= $this->section('app') ?>
<?php $role = session()->get('role'); ?>

<div class="page-heading">
    <h3>Profile Statistics</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Profile Views</h6>
                                    <h6 class="font-extrabold mb-0"><?= $total_views ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Produk</h6>
                                    <h6 class="font-extrabold mb-0"><?= $total_products ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Pesanan</h6>
                                    <h6 class="font-extrabold mb-0"><?= $total_orders ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon red mb-2">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Pembayaran</h6>
                                    <h6 class="font-extrabold mb-0"><?= $total_payments ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Profile Visit</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pesanan Terbaru</h4>
                        </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Transaksi & Pemesan</th>
                                            <th>Total</th>
                                            <th>Status Pembayaran</th>
                                            <th>Status Pesanan</th>
                                            <th>Waktu & Durasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count($latest_orders) > 0): ?>
                                        <?php foreach ($latest_orders as $order): ?>
                                            <tr>

                                                <!-- TRANSAKSI + PEMESAN DIGABUNG -->
                                                <td>
                                                    <div>
                                                        <strong>#<?= $order->transaction_id ?></strong><br>
                                                        <span class="fw-semibold"><?= $order->nama ?></span><br>
                                                        <small class="text-muted">Meja <?= $order->table_number ?></small>
                                                    </div>
                                                </td>

                                                <!-- TOTAL -->
                                                <td class="fw-bold text-success">
                                                    Rp <?= number_format($order->total_price, 0, '.', '.') ?>
                                                </td>

                                                <!-- STATUS PEMBAYARAN -->
                                                <td>
                                                    <small class="text-muted">Pembayaran:</small><br>
                                                    <?php if ($order->payment_status === 'settlement'): ?>
                                                        <span class="badge bg-success">Lunas</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Belum Lunas</span>
                                                    <?php endif; ?>
                                                </td>

                                                <!-- STATUS PESANAN -->
                                                <td>
                                                    <div>
                                                        <small class="text-muted d-block">Status Pesanan</small>

                                                        <?php
                                                        $status = !empty($order->status) ? $order->status : 'unknown';
                                                        ?>

                                                        <?php if ($status === 'pending'): ?>
                                                            <span class="badge bg-warning text-dark">Menunggu</span>

                                                        <?php elseif ($status === 'processing'): ?>
                                                            <span class="badge bg-info">Diproses</span>

                                                        <?php elseif ($status === 'completed'): ?>
                                                            <span class="badge bg-success">Selesai</span>

                                                        <?php elseif ($status === 'cancelled'): ?>
                                                            <span class="badge bg-secondary">Dibatalkan</span>

                                                        <?php else: ?>
                                                            <span class="badge bg-dark">Belum Diproses</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>

                                                <!-- WAKTU & DURASI DIGABUNG -->
                                                <td>
                                                <?php
                                                if (!empty($order->created_at)) {

                                                    $created = strtotime($order->created_at);

                                                    echo '<small class="d-block">';
                                                    echo '<i class="bi bi-receipt text-primary"></i> ';
                                                    echo date('H:i', $created);
                                                    echo '</small>';

                                                    if (!empty($order->updated_at)) {

                                                        $updated = strtotime($order->updated_at);
                                                        $diff = $updated - $created;
                                                        $minutes = floor($diff / 60);

                                                        echo '<small class="d-block">';
                                                        echo '<i class="bi bi-check-circle text-success"></i> ';
                                                        echo date('H:i', $updated);
                                                        echo '</small>';

                                                        echo '<small class="text-muted">';
                                                        echo '<i class="bi bi-clock"></i> ';
                                                        echo $minutes . ' menit';
                                                        echo '</small>';

                                                    } else {

                                                        // Jika belum selesai → hitung durasi sampai sekarang
                                                        $now = time();
                                                        $diff = $now - $created;
                                                        $minutes = floor($diff / 60);

                                                        echo '<small class="d-block text-warning">';
                                                        echo '<i class="bi bi-fire"></i> Belum Selesai';
                                                        echo '</small>';

                                                        echo '<small class="text-muted">';
                                                        echo '<i class="bi bi-clock"></i> ';
                                                        echo $minutes . ' menit berjalan';
                                                        echo '</small>';
                                                    }

                                                } else {
                                                    echo '<span class="text-muted">-</span>';
                                                }
                                                ?>
                                                </td>

                                                <!-- AKSI -->
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#orderDetailModal"
                                                        data-order-id="<?= $order->order_id ?>">
                                                        Detail
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                Belum ada data pesanan
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h4>Review Terbaru</h4>
                </div>
                <div class="card-content pb-4">
                    <?php foreach ($reviews as $review): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title">Nama: <?= $review->nama ?></h6>
                            <p class="card-text"><strong>Produk:</strong> <?= $review->product_name ?></p>
                            <p class="card-text"><strong>Komentar:</strong> <?= $review->comment ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Modal Detail Pesanan -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailModalLabel">Detail Pesanan <span id="modalOrderId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBodyContent">
                Loading details...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#orderDetailModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var orderId = button.data('order-id');
            var modal = $(this);

            modal.find('.modal-title #modalOrderId').text(orderId);
            modal.find('.modal-body').html('Loading details...');

            $.ajax({
                url: "<?= base_url('admin/orders/get_detail/') ?>" + orderId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        var order = response.data;

                        // Badges
                        let paymentBadge = order.payment_status === 'paid'
                            ? '<span class="badge bg-success">Lunas</span>'
                            : '<span class="badge bg-danger">Belum Lunas</span>';

                        let orderBadge = 'Belum Diproses';
                        if (order.status === 'pending') orderBadge = '<span class="badge bg-warning text-dark">Menunggu</span>';
                        else if (order.status === 'processing') orderBadge = '<span class="badge bg-info text-dark">Diproses</span>';
                        else if (order.status === 'completed') orderBadge = '<span class="badge bg-success">Selesai</span>';
                        else if (order.status === 'cancelled') orderBadge = '<span class="badge bg-secondary">Dibatalkan</span>';

                        // Waktu & Durasi
                        let durationHtml = '-';
                        if (order.created_at) {
                            let created = new Date(order.created_at);
                            let createdTime = created.toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'});

                            if (order.updated_at) {
                                let updated = new Date(order.updated_at);
                                let updatedTime = updated.toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'});
                                let diff = Math.floor((updated - created) / 60000);

                                durationHtml = `
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bi bi-receipt text-primary me-2"></i> <strong>${createdTime}</strong> <span class="text-muted ms-2">(Mulai)</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bi bi-check-circle text-success me-2"></i> <strong>${updatedTime}</strong> <span class="text-muted ms-2">(Selesai)</span>
                                    </div>
                                    <div class="text-muted"><i class="bi bi-clock me-1"></i>${diff} menit</div>
                                `;
                            } else {
                                let now = new Date();
                                let diff = Math.floor((now - created) / 60000);

                                durationHtml = `
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bi bi-receipt text-primary me-2"></i> <strong>${createdTime}</strong> <span class="text-muted ms-2">(Mulai)</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-1 text-warning">
                                        <i class="bi bi-fire me-2"></i> Belum Selesai
                                    </div>
                                    <div class="text-muted"><i class="bi bi-clock me-1"></i>${diff} menit berjalan</div>
                                `;
                            }
                        }

                        // Popup content
                        let detailHtml = `
                            <div class="mb-3 p-3 bg-light rounded">
                                <h6 class="text-primary mb-2"><i class="bi bi-info-circle me-1"></i>Informasi Pesanan</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <p class="mb-1"><strong>ID Pesanan:</strong> ${order.id}</p>
                                        <p class="mb-1"><strong>Nama:</strong> ${order.nama || 'N/A'}</p>
                                        <p class="mb-0"><strong>No Meja:</strong> ${order.table_number || 'N/A'}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <p class="mb-1"><strong>Pembayaran:</strong> ${paymentBadge}</p>
                                        <p class="mb-0"><strong>Status Pesanan:</strong> ${orderBadge}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 p-3 bg-light rounded">
                                <h6 class="text-primary mb-2"><i class="bi bi-clock-history me-1"></i>Waktu & Durasi</h6>
                                ${durationHtml}
                            </div>

                            <div class="mb-3 p-3 bg-light rounded">
                                <h6 class="text-primary mb-2"><i class="bi bi-basket2 me-1"></i>Item Pesanan</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered align-middle mb-0">
                                        <thead class="table-light text-center">
                                            <tr>
                                                <th>Produk</th>
                                                <th width="60">Qty</th>
                                                <th width="100">Harga</th>
                                                <th width="120">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                        `;

                        if (order.items && order.items.length > 0) {
                            order.items.forEach(item => {
                                let price = parseInt(item.price) || 0;
                                let qty = parseInt(item.quantity) || 0;
                                let subtotal = price * qty;

                                detailHtml += `
                                    <tr class="text-center">
                                        <td class="text-start">${item.product_name}</td>
                                        <td>${qty}</td>
                                        <td>Rp ${new Intl.NumberFormat('id-ID').format(price)}</td>
                                        <td>Rp ${new Intl.NumberFormat('id-ID').format(subtotal)}</td>
                                    </tr>
                                `;
                            });
                        } else {
                            detailHtml += `
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Tidak ada item untuk pesanan ini</td>
                                </tr>
                            `;
                        }

                        detailHtml += `
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-end mt-3">
                                    <h5>Total: Rp ${new Intl.NumberFormat('id-ID').format(parseInt(order.total_price) || 0)}</h5>
                                </div>
                            </div>
                        `;

                        modal.find('.modal-body').html(detailHtml);

                    } else {
                        modal.find('.modal-body').html('<p class="text-danger">Gagal memuat detail pesanan.</p>');
                    }
                },
                error: function() {
                    modal.find('.modal-body').html('<p class="text-danger">Terjadi kesalahan saat memuat data.</p>');
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>