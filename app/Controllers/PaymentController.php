<?php

namespace App\Controllers;

use App\Models\CartItemModel;
use App\Models\CartModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Models\ProductModel;
use App\Models\TableModel;

class PaymentController extends BaseController
{
    protected $productModel, $cartModel, $cartItemModel, $orderModel, $orderItemModel, $tableModel, $paymentModel, $financeModel;
    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->cartModel = new CartModel();
        $this->cartItemModel = new CartItemModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->tableModel = new TableModel();
        $this->paymentModel = new PaymentModel();
        $this->financeModel = new \App\Models\FinanceModel();
    }

    public function updateStatus()
    {
        log_message('debug', '[PAYMENT] Callback received');

        $data = $this->request->getJSON();
        log_message('debug', '[PAYMENT] Payload: ' . json_encode($data));

        // Validasi data wajib
        if (empty($data->order_id) || empty($data->transaction_status)) {
            log_message('error', '[PAYMENT] Invalid payload');

            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Invalid data'
            ])->setStatusCode(400);
        }

        $trxId = $data->order_id;
        log_message('debug', '[PAYMENT] Transaction ID: ' . $trxId);

        // Cari data transaksi pembayaran
        $trx = $this->paymentModel
            ->where('transaction_id', $trxId)
            ->first();

        if (!$trx) {
            log_message('error', '[PAYMENT] Transaction not found: ' . $trxId);

            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Transaction not found'
            ])->setStatusCode(404);
        }

        $orderId = (int) $trx->order_id;
        log_message('debug', '[PAYMENT] Related Order ID: ' . $orderId);

        // Update status order
        $this->orderModel->update($orderId, ['status' => 'processing']);
        log_message('debug', '[ORDER] Status updated to processing. Order ID: ' . $orderId);

        // Update status pembayaran
        $this->paymentModel
            ->where('order_id', $orderId)
            ->set(['payment_status' => $data->transaction_status])
            ->update();

        log_message(
            'debug',
            '[PAYMENT] Payment status updated to ' . $data->transaction_status . ' for Order ID: ' . $orderId
        );

        // Jika pembayaran sukses
        if ($data->transaction_status === 'settlement') {
            log_message('debug', '[PAYMENT] Settlement confirmed for Order ID: ' . $orderId);

            // Catat keuangan
            $this->financeModel->insert([
                'order_id'     => $orderId,
                'type'         => 'income',
                'amount'       => $data->gross_amount ?? 0,
                'finance_date' => date('Y-m-d H:i:s'),
                'notes'        => 'Pembayaran online untuk order ID ' . $orderId,
            ]);

            log_message(
                'debug',
                '[FINANCE] Income recorded. Order ID: ' . $orderId . ', Amount: ' . ($data->gross_amount ?? 0)
            );

            // Kurangi stok produk
            $orderItems = $this->orderItemModel
                ->where('order_id', $orderId)
                ->findAll();

            $cart = $this->cartModel
                ->where('session_id', session('session')['table_id'])
                ->first();

            if ($cart) {
                // hapus semua item cart
                $this->cartItemModel
                    ->where('cart_id', $cart->id)
                    ->delete();

                // hapus cart
                $this->cartModel->delete($cart->id);
            }

            log_message(
                'debug',
                '[STOCK] Reducing stock for ' . count($orderItems) . ' items. Order ID: ' . $orderId
            );

            foreach ($orderItems as $item) {
                log_message(
                    'debug',
                    '[STOCK] Product ID: ' . $item->product_id . ' | Qty: ' . $item->quantity
                );

                $this->productModel
                    ->where('id', $item->product_id)
                    ->set('stock', 'stock - ' . (int) $item->quantity, false)
                    ->update();
            }

            log_message('debug', '[STOCK] Stock reduction completed. Order ID: ' . $orderId);
        }

        log_message('debug', '[PAYMENT] Callback handled successfully. Order ID: ' . $orderId);

        return $this->response->setJSON(['status' => 'success', 'trx' => $trx]);
    }
}
