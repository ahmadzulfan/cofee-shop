<?php

namespace App\Controllers;

use App\Models\CartItemModel;
use App\Models\CartModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Models\ProductModel;
use App\Models\SettingModel;
use App\Models\TableModel;
use App\Models\UserModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class OrderController extends BaseController
{
    protected $productModel, $cartModel, $cartItemModel, $orderModel, $orderItemModel, $tableModel, $paymentModel, $settingModel, $kasirModel;
    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->cartModel = new CartModel();
        $this->cartItemModel = new CartItemModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->tableModel = new TableModel();
        $this->paymentModel = new PaymentModel();
        $this->settingModel = new SettingModel();
        $this->kasirModel = new UserModel();
    }

    public function checkout()
    {
        $paymentSetting = $this->settingModel->getPaymentSetting();
        $sessionID = session('session')['table_id'] ?? null;

        if (!$sessionID) {
            $currentURL = current_url();
            session()->set('redirect_url', $currentURL);
            return redirect()->to('auth/login')->with('error', 'Silakan login terlebih dahulu!');
        }
        $cart = $this->cartModel
            ->where('session_id', $sessionID)
            ->orderBy('id', 'DESC')
            ->first();
        if (!$cart) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        $data = [
            'title' => 'Checkout',
            'orders' => $this->cartItemModel
                ->select('cart_items.*, products.image, products.name, products.price')
                ->where('cart_id', $cart->id)
                ->join('products', 'cart_items.product_id = products.id')
                ->findAll(),
            'total' => $cart->total,
            'paymentSetting' => $paymentSetting,
        ];

        return view('customer/checkout', $data);
    }

    public function prosesCheckout()
    {
        $db = \Config\Database::connect();

        try {

            $sessionID = session('session')['table_id'] ?? null;
            if (!$sessionID) {
                return redirect()->back()->with('error_message', 'Session table tidak ditemukan');
            }

            // Ambil data dari form
            $paymentMethod = $this->request->getPost('payment_method');
            $notes = $this->request->getPost('notes') ?? '';
            $nama = $this->request->getPost('nama');

            // Validasi payment method
            if (!in_array($paymentMethod, ['cash_on_delivery', 'online_payment'])) {
                return redirect()->back()->with('error_message', 'Metode pembayaran tidak valid');
            }

            // Ambil cart & items
            $cart = $this->cartModel->where('session_id', $sessionID)->first();
            if (!$cart) {
                return redirect()->back()->with('error_message', 'Keranjang kosong');
            }

            $cartItems = $this->cartItemModel->where('cart_id', $cart->id)->findAll();
            if (empty($cartItems)) {
                return redirect()->back()->with('error_message', 'Tidak ada item di keranjang');
            }

            // Hitung total
            $total = 0;
            foreach ($cartItems as $item) {
                $total += $item->subtotal;
            }

            // Buat order
            $orderData = [
                'user_id' => $sessionID,
                'nama' => $nama,
                'total_price' => $total,
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->orderModel->insert($orderData);
            $orderID = $this->orderModel->insertID();
            $trxn_id = 'ORDER-' . str_pad($orderID, 6, '0', STR_PAD_LEFT);

            // Copy cart items ke order items
            foreach ($cartItems as $item) {
                $this->orderItemModel->insert([
                    'order_id' => $orderID,
                    'product_id' => $item->product_id,
                    'quantity' => $item->qty,
                    'price' => $item->subtotal / $item->qty,
                    'subtotal' => $item->subtotal,
                    'notes' => $item->notes ?? '', // Tambahkan notes
                ]);
            }

            // Jika online payment: buat payment record & dapatkan snap token
            if ($paymentMethod === 'online_payment') {
                $snapToken = $this->getSnapToken($trxn_id, $total, $sessionID);

                $this->paymentModel->insert([
                    'order_id' => $orderID,
                    'transaction_id' => $trxn_id,
                    'amount' => $total,
                    'payment_method' => 'online_payment',
                    'payment_status' => 'pending',
                    'snaptoken' => $snapToken,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                // Cash payment: langsung ke order confirmation
                $this->paymentModel->insert([
                    'order_id' => $orderID,
                    'transaction_id' => $trxn_id,
                    'amount' => $total,
                    'payment_method' => 'cash_on_delivery',
                    'payment_status' => 'pending',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                // Hapus cart setelah order selesai
                $this->cartItemModel->where('cart_id', $cart->id)->delete();
                $this->cartModel->delete($cart->id);
            }
            return redirect()->to('order/' . $orderID)->with('success_message', 'Pesanan berhasil dibuat, silahkan lakukan pembayaran');
        } catch (\Exception $e) {
            log_message('error', 'Checkout Error: ' . $e->getMessage());
            return redirect()->back()->with('error_message', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function order($id)
    {
        $order = $this->orderModel->asObject()->where('id', $id)->first();
        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan!');
        }

        $order_items = $this->orderItemModel->select('order_items.*, products.image, products.name')->where('order_id', $id)->join('products', 'order_items.product_id = products.id')->findAll();
        $table = $this->tableModel->asObject()->where('id', $order->user_id)->first();
        $payment = $this->paymentModel->where('order_id', $id)->first();
        $kasir = $this->kasirModel->where('id', $order->kasir_id)->first();
        $order->table = $table->table_number;
        $order->payment = $payment;
        $order->kasir = $kasir;

        return view('customer/order', [
            'title' => 'Detail Pesanan',
            'order' => $order,
            'order_items' => $order_items,
        ]);
    }

    public function strukPDF($id)
    {
        $order = $this->orderModel->find($id);
        $orderItems = $this->orderItemModel->select('order_items.*, products.image, products.name')->where('order_id', $id)->join('products', 'order_items.product_id = products.id')->findAll();
        $table = $this->tableModel->asObject()->where('id', $order->user_id)->first();
        $payment = $this->paymentModel->where('order_id', $id)->first();
        $kasir = $this->kasirModel->where('id', $order->kasir_id)->first();
        $order->table = $table->table_number;
        $order->payment = $payment;
        $order->kasir = $kasir;

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Order tidak ditemukan");
        }

        $data = [
            'order' => $order,
            'order_items' => $orderItems
        ];

        $html = view('customer/order/struk', $data);

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream('struk-order-' . $id . '.pdf', ['Attachment' => true]);
    }

    private function getSnapToken($orderID, $orderAmount, $tableID)
    {
        // Pastikan Midtrans library sudah terinstall
        // composer require midtrans/midtrans-php

        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY'); // Set di .env
        \Midtrans\Config::$isProduction = false; // Ubah ke true untuk production
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $transactionDetails = array(
            'order_id' => $orderID,
            'gross_amount' => $orderAmount,
        );

        $customerDetails = array(
            'table_id' => $tableID,
        );

        $transaction = array(
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
        );

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($transaction);
            return $snapToken;
        } catch (\Exception $e) {
            log_message('error', 'Snap Token Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function submitProductReview($orderId, $productId)
    {
        $comment = $this->request->getPost('comment');

        if (!$comment) {
            return redirect()->back()->with('error', 'Komentar tidak boleh kosong!');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('product_reviews');

        // Cek apakah sudah ada review untuk order + produk ini
        $existing = $builder->where([
            'order_id' => $orderId,
            'product_id' => $productId
        ])->get()->getRow();

        if ($existing) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
        }

        $builder->insert([
            'order_id' => $orderId,
            'product_id' => $productId,
            'comment' => $comment,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil dikirim.');
    }
}
