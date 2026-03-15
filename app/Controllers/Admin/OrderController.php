<?php

namespace App\Controllers\Admin; // Sesuaikan namespace jika berbeda

use App\Controllers\BaseController;
use App\Models\OrderModel; // Asumsikan Anda memiliki OrderModel
use App\Models\OrderItemModel; // Asumsikan Anda memiliki OrderItemModel
use App\Models\PaymentModel; // Asumsikan Anda memiliki PaymentModel
use App\Models\TableModel; // Asumsikan Anda memiliki TableModel (untuk join ke tabel)
use App\Models\ProductModel; // Asumsikan Anda memiliki ProductModel

class OrderController extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $paymentModel;
    protected $tableModel; // Jika digunakan secara langsung di controller
    protected $financeModel;
    protected $productModel; // Jika Anda perlu mengakses produk

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->paymentModel = new PaymentModel();
        $this->tableModel = new TableModel(); // Inisialisasi TableModel jika diperlukan
        $this->financeModel = new \App\Models\FinanceModel();
        $this->productModel = new ProductModel(); // Inisialisasi ProductModel jika diperlukan
    }

    public function index()
    {
        // Ambil tanggal dari parameter GET
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        $role = session()->get('role');

        // 1. Mengambil semua data pesanan (orders)
        // Join dengan tabel 'tables' untuk mendapatkan nomor meja
        // Pastikan 'orders.user_id' adalah kolom yang berelasi dengan 'tables.id' (atau 'tables.table_id' jika nama kolomnya berbeda)
        // Perhatikan bahwa di sini Anda join 'orders.user_id' ke 'tables.id'. Pastikan 'user_id' di tabel 'orders'
        // benar-benar merujuk ke ID dari tabel (misalnya, jika user_id adalah id dari user yang memesan,
        // dan user tersebut dikaitkan dengan meja, maka relasinya benar. Jika orders.table_id yang merujuk ke meja,
        // maka join harus diubah menjadi orders.table_id = tables.id).
        $query = $this->orderModel
                     ->select('orders.*, tables.table_number') // Select orders.* untuk semua kolom order, dan table_number dari tabel
                     ->join('tables', 'orders.user_id = tables.id'); // Perbaiki jika relasi berbeda

        if (session()->get('role') === 'dapur') {
            $query->whereIn('orders.status', ['pending', 'processing']);
        }
        // Terapkan filter tanggal jika ada
        if (!empty($startDate)) {
            // Tambahkan waktu awal hari untuk tanggal mulai
            $query->where('orders.created_at >=', $startDate . ' 00:00:00');
        }
        if (!empty($endDate)) {
            // Tambahkan waktu akhir hari untuk tanggal akhir
            $query->where('orders.created_at <=', $endDate . ' 23:59:59');
        }
        $orderByDirection = ($role === 'dapur') ? 'ASC' : 'DESC';
        $orders = $query->orderBy('orders.created_at', $orderByDirection)->findAll();

        // 2. Mengambil semua item pesanan (order_items) dan menggabungkannya dengan produk
        $orderItems = $this->orderItemModel
                            ->select('order_items.*, products.name AS product_name, products.image, products.price')
                            ->join('products', 'products.id = order_items.product_id')
                            ->orderBy('created_at', 'ASC')
                            ->findAll();

        // 3. Mengelompokkan item pesanan berdasarkan order_id
        $groupedItems = [];
        foreach ($orderItems as $item) {
            $groupedItems[$item->order_id][] = $item;
        }

        // 4. Menambahkan item pesanan ke setiap objek pesanan
        foreach ($orders as $order) {
            $order->items = $groupedItems[$order->id] ?? [];
            // Ambil informasi pembayaran untuk setiap pesanan (jika ada relasi one-to-one atau one-to-many)
            // Asumsi: Ada kolom order_id di tabel payments atau ada cara lain untuk mengaitkan payment ke order
            $order->payment = $this->paymentModel->where('order_id', $order->id)->first(); // Ambil payment pertama yang terkait dengan order ini
        }

        // 5. Mengambil semua data pembayaran (jika Anda ingin menampilkannya secara terpisah atau dalam konteks lain)
        // Jika Anda sudah mengaitkan payment ke setiap order, baris ini mungkin tidak lagi diperlukan
        // $payments = $this->paymentModel->findAll(); 

        $data['title'] = 'Data Pesanan Produk'; // Judul halaman
        $data['orders'] = $orders; // Data pesanan yang sudah digabungkan dengan item dan info meja/pembayaran
        $data['start_date'] = $startDate; // Kirim kembali tanggal untuk mengisi form
        $data['end_date'] = $endDate;     // Kirim kembali tanggal untuk mengisi form

        return view('admin/order/index', $data); // Menampilkan data di view admin/order/index
    }

    // Fungsi baru untuk mendapatkan detail pesanan via AJAX
    public function get_detail($id = null)
    {
        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID Pesanan tidak ditemukan.'
            ]);
        }

        $order = $this->orderModel
                      ->select('orders.*, tables.table_number')
                      ->join('tables', 'orders.user_id = tables.id') // Sesuaikan relasi jika berbeda
                      ->find($id);

        if (!$order) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.'
            ]);
        }

        // Ambil item pesanan yang terkait dengan pesanan ini
        $order->items = $this->orderItemModel
                               ->select('order_items.*, products.name AS product_name, products.image, products.price')
                               ->join('products', 'products.id = order_items.product_id')
                               ->where('order_id', $order->id)
                               ->findAll();

        // Ambil informasi pembayaran
        $order->payment = $this->paymentModel->where('order_id', $order->id)->first();

        // Kembalikan data dalam format JSON
        return $this->response->setJSON([
            'success' => true,
            'data' => $order
        ]);
    }

    public function payCash($id = null)
    {
        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID Pesanan tidak ditemukan.'
            ]);
        }

        try {
            // Update status order ke 'processing'
            $this->orderModel->update($id, [
                'status' => 'processing',
                'kasir_id' => session()->get('user_id')
            ]);

            // Update payment status ke 'settlement'
            $this->paymentModel->where('order_id', $id)->set([
                'payment_status' => 'settlement'
            ])->update();

            // Kurangi stok produk setelah pembayaran settlement
            $orderItems = $this->orderItemModel
                ->where('order_id', $id)
                ->findAll();

            foreach ($orderItems as $item) {
                $this->productModel
                    ->where('id', $item->product_id)
                    ->set('stock', 'stock - ' . (int) $item->quantity, false)
                    ->update();
            }

            $this->financeModel->save([
                'type'      => 'income',
                'amount'    => $this->orderModel->find($id)->total_price,
                'notes'     => 'Pembayaran cash untuk order ID ' . $id,
                'order_id'  => $id, // <-- Tambahkan ini
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Pembayaran berhasil dilakukan '
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function completeOrder($id = null)
    {
        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID Pesanan tidak ditemukan.'
            ]);
        }

        try {
            $this->orderModel->update($id, [
                'status' => 'completed',
                'kasir_id' => session()->get('user_id')
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Pesanan berhasil diselesaikan.'
            ]);
        } catch (\Exception $e) {
             return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function update_items()
    {
        $orderId = $this->request->getPost('order_id');
        $qtys = $this->request->getPost('qty');

        if (!$orderId || !is_array($qtys)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak valid']);
        }

        // Hapus semua item lama
        $this->orderItemModel->where('order_id', $orderId)->delete();

        $total = 0;
        foreach ($qtys as $productId => $qty) {
            if ($qty > 0) {
                $product = $this->productModel->find($productId);
                $subtotal = $product['price'] * $qty;
                $this->orderItemModel->save([
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'price' => $product['price'],
                    'subtotal' => $subtotal
                ]);
                $total += $subtotal;
            }
        }

        // Update total_price pada order
        $this->orderModel->update($orderId, ['total_price' => $total]);

        return $this->response->setJSON(['success' => true]);
    }

    public function riwayat()
    {
        // Ambil tanggal dari parameter GET
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        // Ambil semua data orders dengan status "completed" saja
        $query = $this->orderModel
            ->select('orders.*, tables.table_number') // pilih data dari orders + nomor meja
            ->join('tables', 'orders.user_id = tables.id') // sesuaikan jika yang direlasikan adalah table_id
            ->where('orders.status', 'completed'); // ✅ hanya tampilkan pesanan completed

        // Terapkan filter tanggal jika ada
        if (!empty($startDate)) {
            $query->where('orders.created_at >=', $startDate . ' 00:00:00');
        }
        if (!empty($endDate)) {
            $query->where('orders.created_at <=', $endDate . ' 23:59:59');
        }

        // Ambil hasil query
        $orders = $query->orderBy('orders.created_at', 'ASC')->findAll();

        // Ambil semua item pesanan (join ke produk)
        $orderItems = $this->orderItemModel
            ->select('order_items.*, products.name AS product_name, products.image, products.price')
            ->join('products', 'products.id = order_items.product_id')
            ->orderBy('created_at', 'ASC')
            ->findAll();

        // Kelompokkan item berdasarkan order_id
        $groupedItems = [];
        foreach ($orderItems as $item) {
            $groupedItems[$item->order_id][] = $item;
        }

        // Tambahkan item & pembayaran ke masing-masing order
        foreach ($orders as $order) {
            $order->items = $groupedItems[$order->id] ?? [];
            $order->payment = $this->paymentModel->where('order_id', $order->id)->first();
        }

        // Kirim data ke view
        return view('admin/order/riwayat', [
            'title' => 'Riwayat Pesanan',
            'orders' => $orders,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }



}
