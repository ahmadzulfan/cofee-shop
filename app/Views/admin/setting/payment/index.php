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
                        <?= session()->getFlashdata('success') ? '<div class="alert alert-success">'.session()->getFlashdata('success').'</div>' : '' ?>
                        <?php

                        $payments = ['cash_on_delivery', 'online_payment']
                        
                        ?>

                        <form method="post" action="<?= base_url('admin/setting/payment') ?>">
                            <?php foreach ($payments as $key => $setting) : ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" 
                                        type="checkbox" 
                                        id="payment_<?= $key ?>" 
                                        name="metode_pembayaran[]" 
                                        value="<?= $setting ?>" 
                                        <?= in_array($setting, $settings) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="payment_<?= $key ?>">
                                        <?= ucfirst(str_replace('_', ' ', $setting)) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>

                            <button class="btn btn-primary mt-3" type="submit">Simpan</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
