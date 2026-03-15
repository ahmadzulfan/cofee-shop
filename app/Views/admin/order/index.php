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
                            <h3><?= $title ?? 'Manajemen Pesanan' ?></h3> 
                            <p class="text-subtitle text-muted">Halaman untuk manajemen pesanan produk.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Filter Pesanan Berdasarkan Tanggal</h4>
                        <form action="<?= base_url('admin/orders') ?>" method="GET" class="mb-4">
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
                                    <a href="<?= base_url('admin/orders') ?>" class="btn btn-secondary">Reset Filter</a>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table id="dataTable" class="table">
                                <thead>
                                    <tr>
                                        <th> ID Pesanan </th>
                                        <th> Nama </th>
                                        <th> No Meja </th>
                                        <th> Trx ID </th>
                                        <?php if ($role === 'admin') : ?>
                                        <th> Methode Pembayaran </th>
                                        <th> Status Pembayaran</th>
                                        <?php endif; ?>
                                        <?php if ($role === 'dapur') : ?>
                                        <th> Detail Pesanan </th>
                                        <th> Waktu Pesanan </th>
                                        <th> Status Pesanan</th>
                                        <th>Aksi</th>
                                        <?php endif; ?>
                                        <?php if ($role === 'admin') : ?>
                                        <th> Total Pembayaran </th>
                                        <th>Detail</th>
                                        <?php endif; ?>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $i=1; foreach ($orders as $order) : ?>
                                        <?php if ($order->payment) :?>
                                            <?php if ($role === 'dapur' && strtolower($order->payment->payment_status) !== 'settlement') continue; ?>
                                        <tr>
                                            <td> <?= $i++ ?> </td>
                                            <td> <?= $order->nama ?? 'N/A' ?> </td>
                                            <td> <?= $order->table_number ?? 'N/A' ?> </td>
                                            <td> <?= $order->payment->transaction_id ?? 'Belum Dibayar' ?> </td>
                                            <?php if ($role === 'admin') : ?>
                                            <td> 
                                                <?php if ($order->payment->payment_method === 'cash_on_delivery') {
                                                    echo "Cash";
                                                } else if ($order->payment->payment_method === 'online_payment') {
                                                    echo "Online Payment";
                                                } else {
                                                    echo "Unknown";
                                                } ?> 
                                            </td> 
                                            <td>
                                                <?php
                                                    $status = $order->payment->payment_status ?? 'Pending';
                                                    $badgeClass = '';

                                                    switch (strtolower($status)) {
                                                        case 'settlement':
                                                            $badgeClass = 'bg-success';
                                                            break;
                                                        case 'pending':
                                                            $badgeClass = 'bg-warning';
                                                            break;
                                                        case 'failed':
                                                        case 'cancelled':
                                                            $badgeClass = 'bg-danger';
                                                            break;
                                                        default:
                                                            $badgeClass = 'bg-secondary';
                                                            break;
                                                    }
                                                ?>
                                                <span class="badge <?= $badgeClass ?>"><?= $status ?></span>
                                            </td>
                                            <?php endif; ?>
                                            <?php if ($role === 'dapur') : ?>
                                            <td> 
                                                <?php if (!empty($order->items)) : ?>
                                                    <ul class="mb-0 ps-3">
                                                        <?php foreach ($order->items as $item): ?>
                                                            <li><?= esc($item->product_name) ?> (<?= esc($item->quantity) ?>x)</li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php else : ?>
                                                    <span class="text-muted">Tidak ada item</span>
                                                <?php endif; ?>
                                            </td>
                                            <td> <?= $order->created_at ?? 'N/A' ?> </td>
                                            <td>
                                                <?php
                                                    $orderStatus = $order->status ?? 'pending';
                                                    $badgeStatusOrder = '';

                                                    switch (strtolower($orderStatus)) {
                                                        case 'processing':
                                                            $badgeStatusOrder = 'bg-primary';
                                                            break;
                                                        case 'pending':
                                                            $badgeStatusOrder = 'bg-warning';
                                                            break;
                                                        case 'completed':
                                                            $badgeStatusOrder = 'bg-success';
                                                            break;
                                                        case 'cancelled':
                                                            $badgeStatusOrder = 'bg-danger';
                                                            break;
                                                        default:
                                                            $badgeStatusOrder = 'bg-secondary';
                                                            break;
                                                    }
                                                ?>
                                                <span class="badge <?= $badgeStatusOrder ?>"><?= $orderStatus ?></span>
                                            </td>
                                            <?php endif; ?>
                                            <?php if ($role === 'dapur') : ?>
                                                <td>
                                                    <!-- Tombol aksi lainnya -->
                                                    <?php if ($order->payment->payment_method === 'cash_on_delivery' && $order->payment->payment_status === 'pending') : ?>
                                                        <button type="button" class="btn btn-success btn-sm btn-bayar-cash" data-order-id="<?= $order->id ?>" style="color: white;">
                                                            <i class="bi bi-cash"></i>
                                                        </button>
                                                    <?php elseif ($order->status === 'processing') : ?>
                                                        <button type="button" class="btn btn-primary btn-sm btn-selesaikan" data-order-id="<?= $order->id ?>" style="color: white;">
                                                            <i class="bi bi-check"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endif; ?>
                                            <?php if ($role === 'admin') : ?>
                                            <td> Rp <?= number_format($order->total_price ?? 0, 0, '.', '.') ?> </td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#orderDetailModal" data-order-id="<?= $order->id ?>" style="color: white;">
                                                    <i class="bi bi-info-circle"></i>
                                                </button>
                                                <?php if ($order->payment->payment_method === 'cash_on_delivery' && $order->payment->payment_status === 'pending') : ?>
                                                    <button type="button" class="btn btn-success btn-sm btn-bayar-cash" data-order-id="<?= $order->id ?>" style="color: white;">
                                                        <i class="bi bi-cash"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                            <?php endif; ?>
                                            
                                        </tr>
                                        <?php endif;?>
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

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    // Fungsi deleteCategory(id) tetap ada jika mungkin digunakan di bagian lain dari template admin,
    // tetapi tidak ada tombol aksi yang memicunya di halaman ini lagi.
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

    // JavaScript untuk memuat detail pesanan ke modal menggunakan AJAX
    $(document).ready(function() {
        // Inisialisasi Flatpickr
        flatpickr(".flatpickr", {
            dateFormat: "Y-m-d", // Format tanggal yang diinginkan (sesuai dengan format database jika perlu)
            allowInput: true, // Memungkinkan input manual
            // Anda bisa menambahkan opsi lain seperti minDate, maxDate, dll.
        });

        $('#orderDetailModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Tombol yang memicu modal
            var orderId = button.data('order-id'); // Ekstrak info dari atribut data-order-id
            var modal = $(this);

            modal.find('.modal-title #modalOrderId').text(orderId); // Tampilkan ID di judul modal
            modal.find('.modal-body').html('Loading details...'); // Reset konten modal

            // Lakukan panggilan AJAX untuk mendapatkan detail pesanan
            $.ajax({
                url: "<?= base_url('admin/orders/get_detail/') ?>" + orderId,
                type: "GET",
                dataType: "json", // Harap server mengembalikan JSON
                success: function(response) {
                    if (response.success) {
                        var order = response.data;
                        var detailHtml = `
                            <p><strong>ID Pesanan:</strong> ${order.id}</p>
                            <p><strong>No Meja:</strong> ${order.table_number || 'N/A'}</p>
                            <p><strong>Tanggal Pesanan:</strong> ${order.created_at || 'N/A'}</p>
                            <hr>
                            <h5>Item Pesanan:</h5>
                            <ul>
                        `;
                        if (order.items && order.items.length > 0) {
                            order.items.forEach(function(item) {
                                detailHtml += `
                                    <li>
                                        ${item.product_name} (${item.quantity}x) - Rp ${new Intl.NumberFormat('id-ID').format(item.price)}
                                        <br>
                                        <img src="<?= base_url('uploads/products/') ?>${item.image}" alt="${item.product_name}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; margin-top: 5px;">
                                        <br>
                                        <strong>Notes:</strong> ${item.notes || 'Tidak ada'}
                                        </li>
                                `;
                            });
                        } else {
                            detailHtml += `<li>Tidak ada item dalam pesanan ini.</li>`;
                        }
                        detailHtml += `</ul><hr>`;

                        if (order.payment) {
                            detailHtml += `
                                <h5>Detail Pembayaran:</h5>
                                <p><strong>Trx ID:</strong> ${order.payment.transaction_id || 'Belum Dibayar'}</p>
                                <p><strong>Metode Pembayaran:</strong> ${order.payment.payment_method || 'Belum Dibayar'}</p>
                                <p><strong>Status Pembayaran:</strong> <span class="badge ${getBadgeClass(order.payment.payment_status)}">${order.payment.payment_status || 'Pending'}</span></p>
                                <p><strong>Total Pembayaran:</strong> Rp ${new Intl.NumberFormat('id-ID').format(order.total_price || order.total_amount || 0)}</p>
                            `;
                        } else {
                            detailHtml += `<h5>Pembayaran:</h5><p>Belum ada informasi pembayaran.</p>`;
                        }
                        
                        modal.find('.modal-body').html(detailHtml);

                        // Tambahkan tombol Edit Item Pesanan di bawah detail
                        if (order.status === 'pending') {
                            modal.find('.modal-body').append(`
                                <div class="mt-3 text-end">
                                    <button type="button" class="btn btn-warning btn-edit-items" data-order-id="${order.id}">
                                        <i class="bi bi-pencil-square"></i> Edit Item Pesanan
                                    </button>
                                </div>
                            `);
                        }
                    } else {
                        modal.find('.modal-body').html('<p class="text-danger">Gagal memuat detail pesanan.</p>');
                    }
                },
                error: function(xhr, status, error) {
                    modal.find('.modal-body').html('<p class="text-danger">Terjadi kesalahan saat memuat detail.</p>');
                    console.error("AJAX Error:", status, error, xhr.responseText);
                }
            });
        });

        // Fungsi helper untuk mendapatkan kelas badge (sesuai dengan yang ada di tabel)
        function getBadgeClass(status) {
            switch (status ? status.toLowerCase() : '') {
                case 'settlement':
                case 'completed': // Tambahkan 'completed' jika ada status ini
                case 'success':
                case 'paid':
                    return 'bg-success';
                case 'pending':
                    return 'bg-warning';
                case 'failed':
                case 'cancelled':
                case 'batal':
                    return 'bg-danger';
                default:
                    return 'bg-secondary';
            }
        }
    });

    $(document).on('click', '.btn-bayar-cash', function () {
        const id = $(this).data('order-id');
        Swal.fire({
            title: "Selesaikan Pembayaran?",
            text: "Apakah anda yakin untuk selesaikan pesanan ini!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Selesaikan!"
        }).then((result) => {
            if (result.isConfirmed) {
                console.log("Button clicked, proceeding with payment...");

                $.ajax({
                    url: `<?= base_url() ?>admin/orders/${id}/paycash`,
                    method: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                title: "Pembayaran Berhasil!",
                                text: "Pesanan berhasil diselesaikan.",
                                icon: "success"
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: "Gagal!",
                                text: response.message || "Terjadi kesalahan saat menyelesaikan pesanan.",
                                icon: "error"
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: "Error!",
                            text: "Terjadi kesalahan saat menghubungi server.",
                            icon: "error"
                        });
                    }
                });
            }
        });
    });


    $(document).on('click', '.btn-selesaikan', function(){
    const id = $(this).data('order-id');
    Swal.fire({
        title: "Selesaikan Pesanan?",
        text: "Apakah anda yakin untuk selesaikan pesanan ini!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Selesaikan!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `<?= base_url() ?>admin/orders/${id}/complete`,
                method: 'POST',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Pesanan berhasil diselesaikan.",
                            icon: "success"
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Gagal!",
                            text: response.message || "Terjadi kesalahan saat menyelesaikan pesanan.",
                            icon: "error"
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        title: "Error!",
                        text: "Terjadi kesalahan saat menghubungi server.",
                        icon: "error"
                    });
                }
            });
        }
    });
});

$(document).on('click', '.btn-edit-items', function() {
    const orderId = $(this).data('order-id');
    // Ambil semua produk dan order items dari server
    $.ajax({
        url: "<?= base_url('admin/products/all') ?>",
        type: "GET",
        dataType: "json",
        success: function(response) {
            if (response.success) {
                let products = response.products;
                
                // Ambil order items yang sudah ada
                $.ajax({
                    url: "<?= base_url('admin/orders/get_detail/') ?>" + orderId,
                    type: "GET",
                    dataType: "json",
                    success: function(orderResponse) {
                        if (orderResponse.success) {
                            let orderItems = orderResponse.data.items || [];
                            let itemsMap = {};
                            
                            // Buat map dari order items
                            orderItems.forEach(item => {
                                itemsMap[item.product_id] = item.quantity;
                            });
                            
                            let html = `<form id="editOrderItemsForm">
                                <input type="hidden" name="order_id" value="${orderId}">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                            
                            products.forEach(product => {
                                let currentQty = itemsMap[product.id] || 0;
                                html += `
                                    <tr>
                                        <td>${product.name}</td>
                                        <td>
                                            <input type="number" min="0" name="qty[${product.id}]" value="${currentQty}" class="form-control" style="width:80px;">
                                        </td>
                                    </tr>
                                `;
                            });
                            
                            html += `</tbody></table>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>`;

                            Swal.fire({
                                title: "Edit Item Pesanan",
                                html: html,
                                showConfirmButton: false,
                                width: 700,
                                didOpen: () => {
                                    $('#editOrderItemsForm').on('submit', function(e) {
                                        e.preventDefault();
                                        $.ajax({
                                            url: "<?= base_url('admin/orders/update_items') ?>",
                                            type: "POST",
                                            data: $(this).serialize(),
                                            dataType: "json",
                                            success: function(res) {
                                                if (res.success) {
                                                    Swal.fire("Berhasil", "Item pesanan berhasil diupdate!", "success")
                                                        .then(() => location.reload());
                                                } else {
                                                    Swal.fire("Gagal", res.message, "error");
                                                }
                                            },
                                            error: function() {
                                                Swal.fire("Error", "Terjadi kesalahan server.", "error");
                                            }
                                        });
                                    });
                                }
                            });
                        }
                    }
                });
            } else {
                Swal.fire("Gagal", "Gagal mengambil data produk.", "error");
            }
        },
        error: function() {
            Swal.fire("Error", "Terjadi kesalahan server.", "error");
        }
    });
});
</script>

<?= $this->endSection() ?>
