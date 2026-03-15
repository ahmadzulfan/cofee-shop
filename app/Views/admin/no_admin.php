<?= $this->extend('admin/template/index.php') ?>
<?= $this->section('app') ?>

<div class="page-content">
    <section class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm border-0 text-center py-4 px-3">
                <div class="mb-3">
                    <i class="bi bi-house-door-fill text-primary" style="font-size: 2.5rem;"></i>
                </div>
                <h3 class="mb-2">Selamat Datang!</h3>
                <p class="text-muted mb-3">Semoga harimu menyenangkan 😊</p>
                <hr class="my-3">
                <div class="row text-center">
                    <div class="col-4">
                        <div class="fw-bold text-primary"><?= $total_products ?></div>
                        <small class="text-muted">Produk</small>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold text-success"><?= $total_orders ?></div>
                        <small class="text-muted">Pesanan</small>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold text-warning">Rp <?= number_format($total_payments, 0, '.', '.') ?></div>
                        <small class="text-muted">Pendapatan</small>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>
