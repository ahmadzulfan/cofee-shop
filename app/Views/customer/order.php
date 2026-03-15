<?= $this->extend('Customer/template/index.php') ?>
<?= $this->section('app') ?>
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= env('MIDTRANS_CLIENT_KEY') ?>"></script>
<div class="container py-5">
    <!-- Tombol Kembali -->
    <div class="mb-4">
        <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Beranda
        </a>
    </div>

    <h3 class="fw-bold mb-4">Detail Pesanan</h3>

    <div class="row g-4">
        <!-- Info Pesanan -->
        <div class="col-lg-7">
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3">Informasi Pemesan</h5>
                    <ul class="list-unstyled">
                        <?php if (!empty($order->kasir->name)) : ?>
                            <li><strong>Kasir: </strong><?= $order->kasir->name ?></li>
                        <?php elseif (empty($order->kasir->name) && $order->payment->payment_status == 'settlement'): ?>
                            <li><strong>Kasir: </strong>Admin</li>
                        <?php endif; ?>
                        <li><strong>Trx ID: </strong><?= $order->payment->transaction_id ?></li>
                        <li><strong>Nomor Meja: </strong><?= $order->table ?></li>
                        <li><strong>Nama:</strong> <?= $order->nama ?></li>
                        <li><strong>Metode Pembayaran:</strong>
                            <?= $order->payment->payment_method === 'cash_on_delivery' ? 'Cash' : $order->payment->payment_method ?>
                        </li>
                        <li><strong>Status:</strong> <?php if ($order->payment->payment_status == 'pending') {
                                                            echo '<span class="badge bg-warning text-dark">Menunggu Pembayaran</span>';
                                                        } else if ($order->payment->payment_status == 'settlement') {
                                                            echo '<span class="badge bg-success">Pembayaran Diterima</span>';
                                                        } else if ($order->payment->payment_status == 'failed') {
                                                            echo '<span class="badge bg-danger">Pesanan Dibatalkan</span>';
                                                        }
                                                        ?></li>
                        <li><strong>Tanggal Pemesanan:</strong> <?= date('d M Y, H:i', strtotime($order->created_at)) ?></li>
                    </ul>
                </div>
            </div>
            <?php if ($order->status == 'pending'): ?>
                <?php if ($order->payment->payment_method === 'online_payment') : ?>
                    <div id="btn-bayar" class="btn btn-primary" data-trx="<?= $order->payment->transaction_id ?>" data-snaptoken="<?= $order->payment->snaptoken ?>">Bayar</div>
                <?php else: ?>
                    <div class="alert alert-warning" role="alert">
                        Silakan lakukan pembayaran di kasir untuk menyelesaikan pesanan Anda.
                    </div>
                <?php endif; ?>
            <?php elseif ($order->status == 'processing'): ?>
                <div class="alert alert-success" role="alert">
                    Pembayaran Anda telah diterima. Terima kasih telah berbelanja!
                </div>
                <a href="<?= base_url('order/struk/' . $order->id) ?>" class="btn btn-outline-success rounded-pill px-4 shadow-sm mb-4" target="_blank">
                    <i class="bi bi-file-earmark-pdf me-2"></i> Download Struk (PDF)
                </a>
                <div class="card mt-4 shadow-sm rounded-4">
                    <?php foreach ($order_items as $item): ?>
                        <div class="card mb-3 shadow-sm rounded-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url('uploads/products/' . $item->image) ?>" class="rounded me-3" width="60" height="60" alt="<?= $item->name ?>">
                                    <div>
                                        <h6 class="mb-1"><?= $item->name ?></h6>
                                        <small><?= $item->quantity ?> x Rp <?= number_format($item->price, 0, ',', '.') ?></small>
                                    </div>
                                </div>

                                <!-- Form Review -->
                                <form action="<?= base_url('order/review/' . $order->id . '/' . $item->product_id) ?>" method="post" class="mt-3">
                                    <div class="mb-2">
                                        <label for="comment-<?= $item->product_id ?>" class="form-label">Komentar untuk produk ini</label>
                                        <textarea name="comment" id="comment-<?= $item->product_id ?>" rows="2" class="form-control" placeholder="Tulis ulasan Anda..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-success rounded-pill">Kirim Ulasan</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>


                <?php elseif ($order->status == 'completed'): ?>
                    <div class="alert alert-danger" role="alert">
                        Pesanan Anda telah dibatalkan. Silakan hubungi kami untuk informasi lebih lanjut.
                    </div>
                <?php endif; ?>
                </div>

                <!-- Ringkasan Produk -->
                <div class="col-lg-5">
                    <div class="card shadow-sm rounded-4">
                        <div class="card-body">
                            <h5 class="fw-semibold mb-3">Ringkasan Produk</h5>
                            <?php foreach ($order_items as $item): ?>
                                <div class="d-flex align-items-center mb-3">
                                    <img src="<?= base_url('uploads/products/' . $item->image) ?>" class="rounded me-3" width="60" height="60" alt="<?= esc($item->name) ?>">
                                    <div>
                                        <h6 class="mb-1"><?= esc($item->name) ?></h6>
                                        <small class="text-muted"><?= $item->quantity ?> x Rp <?= number_format($item->price, 0, ',', '.') ?></small>
                                    </div>
                                    <div class="ms-auto fw-semibold">
                                        Rp <?= number_format($item->quantity * $item->price, 0, ',', '.') ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <hr>

                            <!-- Total -->
                            <div class="d-flex justify-content-between">
                                <strong>Total</strong>
                                <strong class="text-success">Rp <?= number_format($order->total_price, 0, ',', '.') ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('#btn-bayar').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const trxId = btn.dataset.trx;
                const snapToken = btn.dataset.snaptoken;
                const url = "<?= base_url('api/status/payment?trx=') ?>" + trxId;

                const modalEl = document.getElementById('modalBooking');
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
                // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token.
                // Also, use the embedId that you defined in the div above, here.
                window.snap.embed(snapToken, {
                    embedId: 'snap-container',
                    onSuccess: function(result) {
                        // Kirim ke server untuk update status
                        fetch(url, {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "<?= csrf_hash() ?>"
                                },
                                body: JSON.stringify({
                                    order_id: result.order_id,
                                    transaction_status: result.transaction_status,
                                    payment_type: result.payment_type,
                                    gross_amount: result.gross_amount
                                })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error("Gagal mengupdate status di server");
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log("Status pembayaran diperbarui:", data);
                                modal.hide();
                                window.location.reload();
                            })
                            .catch(error => {
                                console.error("Error:", error);
                                modal.hide();
                                alert("Terjadi kesalahan saat mengupdate status ke server.");
                            });
                    },
                    onPending: function(result) {
                        /* You may add your own implementation here */
                        modal.hide();
                        alert("wating your payment!");
                        console.log(result);
                    },
                    onError: function(result) {
                        modal.hide();
                        /* You may add your own implementation here */
                        alert("payment failed!");
                        console.log(result);
                    },
                    onClose: function() {
                        modal.hide();
                        /* You may add your own implementation here */
                        alert('you closed the popup without finishing the payment');
                    }
                });
            });
        });
    </script>
    <?= $this->endSection() ?>