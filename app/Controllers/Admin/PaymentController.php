<?php 

namespace App\Controllers\Admin;

use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\PaymentModel;

class PaymentController extends BaseController
{
    protected $orderModel, $orderItemModel, $paymentModel;
    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->paymentModel = new PaymentModel();
    }
    public function index()
    {
        $payments = $this->paymentModel->findAll();
        $orders = $this->orderModel->join('tables', 'orders.user_id = tables.id')->findAll();  // Mengambil semua data kategori produk
        $orderItems = $this->orderItemModel
        ->select('order_items.*, products.name AS product_name, products.image, products.price')
        ->join('products', 'products.id = order_items.product_id')
        ->findAll();
        $groupedItems = [];
        foreach ($orderItems as $item) {
            $groupedItems[$item->order_id][] = $item;
        }
        foreach ($orders as $order) {
            $order->items = $groupedItems[$order->id] ?? [];
        }        
        $data['title'] = 'Order';  // Judul halaman
        $data['payments'] = $payments;
        return view('admin/payment/index', $data);  // Menampilkan kategori produk di view
    }

}
