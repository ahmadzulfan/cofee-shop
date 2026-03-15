<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Order</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Struk Pembelian</h2>

    <p><strong>Kasir: </strong>
    <?php if (!empty($order->kasir->name)) : ?>
        <?= $order->kasir->name ?>
    <?php else: ?>
        Admin
    <?php endif; ?>
    </p>
    <p><strong>Trx ID:</strong> <?= $order->payment->transaction_id ?></p>
    <p><strong>Nomor Meja:</strong> <?= $order->table ?></p>
    <p><strong>Nama:</strong> <?= $order->nama ?></p>
    <p><strong>Metode Pembayaran:</strong> <?= $order->payment->payment_method ?></p>
    <p><strong>Status:</strong> <?= esc($order->payment->payment_status) ?></p>
    <p><strong>Tanggal:</strong> <?= date('d M Y, H:i', strtotime($order->created_at)) ?></p>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order_items as $item): ?>
            <tr>
                <td><?= esc($item->name) ?></td>
                <td><?= $item->quantity ?></td>
                <td>Rp <?= number_format($item->price, 0, ',', '.') ?></td>
                <td>Rp <?= number_format($item->price * $item->quantity, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total</th>
                <th>Rp <?= number_format($order->total_price, 0, ',', '.') ?></th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
