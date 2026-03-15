<?= $this->extend('Customer/template/index.php') ?>
<?= $this->section('app') ?>
    <div class="container py-5">
    <!-- Tombol Kembali -->
    <div class="mb-4">
        <a href="<?= base_url('/keranjang') ?>" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm">
        <i class="bi bi-arrow-left me-2"></i> Kembali ke keranjang
        </a>
    </div>

    <h3 class="fw-bold mb-4">Checkout</h3>

    <div class="row g-4">
        <!-- Kolom Kiri: Formulir Checkout -->
        <div class="col-lg-7">
        <!-- Info Pengiriman -->
        <div class="card shadow-sm rounded-4 mb-4">
            <div class="card-body">
            <h5 class="fw-semibold mb-3">Metode Pembayaran</h5>
            <form action="<?= base_url('checkout') ?>" method="post">
                <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control rounded-pill" required>
                </div>
                
                <?php foreach ($paymentSetting as $key => $setting) : ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="<?= $setting ?>" value="<?= $setting ?>">
                        <label class="form-check-label" for="<?= $setting ?>">
                            <?php if ($setting === 'cash_on_delivery') : ?>
                                Cash
                            <?php else: ?>
                                Online Payment
                            <?php endif; ?>
                        </label>
                    </div>
                <?php endforeach; ?>

                <!-- Tombol Checkout -->
                <div class="mt-4">
                <button type="submit" class="btn btn-success rounded-pill px-5">
                    <i class="bi bi-bag-check-fill me-2"></i> Konfirmasi & Checkout
                </button>
                </div>
            </form>
            </div>
        </div>
        </div>

        <!-- Kolom Kanan: Ringkasan Pesanan -->
        <div class="col-lg-5">
        <div class="card shadow-sm rounded-4">
            <div class="card-body">
            <h5 class="fw-semibold mb-3">Ringkasan Pesanan</h5>

            <!-- Contoh produk di keranjang -->
            <?php foreach ($orders as $item): ?>
                <div class="d-flex align-items-center mb-3">
                <img src="<?= base_url('uploads/products/' . $item->image) ?>" class="rounded me-3" width="60" height="60" alt="<?= $item->name ?>">
                <div>
                    <h6 class="mb-1"><?= $item->name ?></h6>
                    <small class="text-muted"><?= $item->qty ?> x Rp <?= number_format($item->price, 0, ',', '.') ?></small>
                    <div class="small text-muted">Notes: <?= $item->notes ?? 'Tidak ada' ?></div> <!-- Menampilkan notes jika ada -->
                </div>
                <div class="ms-auto fw-semibold">
                    Rp <?= number_format($item->qty * $item->price, 0, ',', '.') ?>
                </div>
                </div>
            <?php endforeach; ?>

            <hr>

            <!-- Total -->
            <div class="d-flex justify-content-between">
                <strong>Total</strong>
                <strong class="text-success">Rp <?= number_format($total, 0, ',', '.') ?></strong>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
<?= $this->endSection() ?>

<script>
// Di bagian loadCart atau render item, tambahkan tampilan notes
function loadCart() {
  $.get(`<?= base_url() ?>api/${id}/getcart`, function(res){
    const items = res.carts || [];
    const $list = $('#cart-items');
    $list.empty();

    if (!items.length) {
      // ...existing code...
    }

    // render each item
    items.forEach(it => {
      const itemId = it.items_id ?? it.id ?? it.product_id;
      const qty = parseInt(it.qty) || 0;
      const subtotal = parseFloat(it.subtotal) || 0;
      const name = it.name ?? it.nama ?? 'Produk';
      const pricePer = qty ? (subtotal / qty) : 0;
      const notes = it.notes ?? '';

      const $li = $(`
        <li class="list-group-item d-flex align-items-center justify-content-between py-3">
          <div class="flex-grow-1">
            <div class="fw-semibold">${name}</div>
            <div class="small text-muted">Qty: ${qty} x ${formatRupiah(pricePer)}</div>
            <div class="small text-muted">Notes: ${notes || 'Tidak ada'}</div> <!-- Tambahkan tampilan notes -->
          </div>
          <div class="d-flex align-items-center gap-2">
            <div class="fw-bold text-success">${formatRupiah(subtotal)}</div>
          </div>
        </li>
      `);
      $list.append($li);
    });

    // ...existing code...
  });
}
</script>