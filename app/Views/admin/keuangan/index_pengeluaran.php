<?= $this->extend('admin/template/index.php') ?>
<?= $this->section('app') ?>

<div class="page-heading mb-4">
    <h3>Rekapan Keuangan</h3>
    <p class="text-muted">Pantau arus kas harian secara ringkas dan jelas</p>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12">
            <!-- Filter Tanggal -->
            <form action="<?= base_url('admin/keuangan/dana_keluar') ?>" method="GET" class="mb-4">
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
                        <a href="<?= base_url('admin/keuangan/dana_keluar') ?>" class="btn btn-secondary">Reset Filter</a>
                    </div>
                </div>
            </form>

            <!-- Card Ringkasan -->
            <div class="row g-3 mb-4">
                <!-- <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted">Uang Masuk</h6>
                                <h4 class="text-success">Rp <?= number_format($totalIncome, 0, ',', '.') ?></h4>
                            </div>
                            <div class="bg-success text-white rounded-circle p-3">
                                <i class="bi bi-arrow-down-circle fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted"> Dana Keluar</h6>
                                <div class="d-flex">
                                    <h4 class="text-danger">Rp <?= number_format($totalExpense, 0, ',', '.') ?></h4>
                                    <a href="#" class="text-danger ms-2" data-bs-toggle="modal" data-bs-target="#modalTambahPengeluaran" title="Tambah Transaksi Keluar">
                                        <i class="bi bi-plus-circle"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="bg-danger text-white rounded-circle p-3">
                                <i class="bi bi-arrow-up-circle fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted">Sisa Kas</h6>
                                <h4 class="text-primary">Rp <?= number_format($totalIncome - $totalExpense, 0, ',', '.') ?></h4>
                            </div>
                            <div class="bg-primary text-white rounded-circle p-3">
                                <i class="bi bi-wallet2 fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- Tabel Transaksi -->
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Transaksi</h5>
                    <a href="<?= base_url('admin/keuangan/ekspor/pengeluaran') ?>?start_date=<?= esc($start_date ?? '') ?>&end_date=<?= esc($end_date ?? '') ?>" class="btn btn-danger btn-sm" target="_blank">
                        <i class="bi bi-file-earmark-pdf"></i> Ekspor PDF
                    </a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Masuk</th>
                                <th>TRX ID</th>
                                <!-- <th>Jenis</th> -->
                                <th>Catatan</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($transactions)) : ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Tidak ada transaksi.</td>
                                </tr>
                            <?php else : $no = 1; foreach ($transactions as $t) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= date('d M Y', strtotime($t->finance_date)) ?></td>
                                    <td><?= $t->transaction_id ?? '-' ?></td>
                                    <!-- <td>
                                        <span class="badge bg-<?= $t->type === 'income' ? 'success' : 'danger' ?>">
                                            <?= $t->type === 'income' ? 'Uang Masuk' : 'Uang Keluar' ?>
                                        </span>
                                    </td> -->
                                    <td><?= esc($t->notes) ?></td>
                                    <td> 
                                        <?php if (!empty($t->items)) : ?>
                                            <ul class="mb-0 ps-3">
                                                <?php foreach ($t->items as $item): ?>
                                                    <li><?= esc($item->product_name) ?> 
                                                    </li>  <!-- history detail dan harga -->
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else : ?>
                                            <span class="text-muted">Tidak ada item</span>
                                        <?php endif; ?>
                                    </td>
                                    <td> 
                                        <?php if (!empty($t->items)) : ?>
                                            <ul class="mb-0 ps-3">
                                                <?php foreach ($t->items as $item): ?>
                                                    <li><?= esc('Rp. ' . number_format($item->price, 0, ',', '.')) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else : ?>

                                            <span class="text-muted">Tidak ada item</span>
                                        <?php endif; ?>
                                    </td>
                                    <td> 
                                        <?php if (!empty($t->items)) : ?>
                                            <ul class="mb-0 ps-3">
                                                <?php foreach ($t->items as $item): ?>
                                                    <li><?= esc($item->quantity) ?> 
                                                    </li>  <!-- history detail dan harga -->
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else : ?>
                                            <span class="text-muted">Tidak ada item</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end"><span class="badge bg-<?= $t->type === 'income' ? 'success' : 'danger' ?>">
                                            Rp <?= number_format($t->amount, 0, ',', '.') ?>
                                    </span></td>
                                </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- Modal Tambah Pengeluaran -->
<div class="modal fade" id="modalTambahPengeluaran" tabindex="-1"
     aria-labelledby="modalTambahPengeluaranLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formTambahPengeluaran">
                <?= csrf_field() ?>

                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahPengeluaranLabel">
                        Tambah Pengeluaran
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <input type="hidden" name="type" value="expense">

                    <div class="mb-3">
                        <label for="expenseAmount" class="form-label">Jumlah (Rp)</label>
                        <input type="number" class="form-control" id="expenseAmount"
                               name="amount" min="0" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="expenseDate" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="expenseDate"
                               name="finance_date" value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="expenseNotes" class="form-label">Catatan (opsional)</label>
                        <textarea class="form-control" id="expenseNotes"
                                  name="notes" rows="2"></textarea>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    flatpickr(".flatpickr", {
        dateFormat: "Y-m-d",
        defaultDate: "today",
        allowInput: true,
        locale: "id" // bahasa Indonesia
    });
</script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formTambahPengeluaran');

    form.addEventListener('submit', async function (e) {
        e.preventDefault(); // Cegah reload

        const formData = new FormData(form);

        try {
            const response = await fetch("<?= base_url('admin/keuangan/expense/store') ?>", {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Pengeluaran berhasil disimpan.',
                    icon: 'success'
                }).then(() => {
                    location.reload(); // Reload halaman untuk memperbarui data
                });
            } else {
                Swal.fire('Gagal!', result.message || 'Gagal menyimpan data.', 'error');
            }
        } catch (err) {
            console.error(err);
            Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
        }
    });
});
</script>
<?= $this->endSection() ?>
