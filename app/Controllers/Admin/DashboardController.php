<?php

namespace App\Controllers\Admin;

use App\Models\ProductModel;
use App\Controllers\BaseController;
use App\Models\PaymentModel;
use App\Models\ProductReviewModel;

class DashboardController extends BaseController
{
    protected $productreviewModel;
    protected $paymentModel;

    public function __construct()
    {
        $this->productreviewModel = new ProductReviewModel();
    }
    
    public function index()
    {
        $db = \Config\Database::connect();

        try {
            // === Ambil total view dari tabel view_counter ===
            $viewRow = $db->table('view_counter')->where('id', 1)->get()->getRow();
            $totalViews = $viewRow ? (int)$viewRow->total_views : 0;

            // === Ambil total produk ===
            $totalProducts = $db->table('products')->countAllResults();

            // === Ambil total order & payment ===
            $totalOrders = $db->table('orders')->countAllResults();
            $totalPayments = $db->table('payments')->countAllResults();

            // === Ambil review terbaru (maks. 5 data) ===
            $reviews = $this->productreviewModel
                ->select('product_reviews.*, orders.nama as nama, products.name as product_name')
                ->join('orders', 'orders.id = product_reviews.order_id')
                ->join('products', 'products.id = product_reviews.product_id')
                ->asObject()
                ->findAll();
            $reviews = array_slice($reviews, 0, 5); // Limit to 5

            // === Ambil order terbaru (maks. 5 data) ===
            $latestOrders = $db->table('orders')
                ->select('orders.*, orders.id as order_id, tables.table_number, payments.*')
                ->join('tables', 'tables.id = orders.user_id', 'left')
                ->join('payments', 'payments.order_id = orders.id', 'left')
                ->orderBy('orders.created_at', 'DESC')
                ->limit(5)
                ->get()
                ->getResult();

            // === Siapkan data ke view ===
            $data = [
                'title'          => 'Dashboard Admin',
                'total_views'    => $totalViews,
                'total_products' => $totalProducts,
                'total_orders'   => $totalOrders,
                'total_payments' => $totalPayments,
                'latest_orders'  => $latestOrders,
                'reviews'        => $reviews,
            ];

            if (session()->get('role') !== 'pemilik' && session()->get('role') !== 'admin') {
                return view('admin/no_admin', $data);
            }

            return view('admin/index', $data);
            
        } catch (\Exception $e) {
            log_message('error', 'Gagal memuat dashboard admin: ' . $e->getMessage());

            // Opsional: tampilkan pesan error jika dalam mode development
            if (ENVIRONMENT === 'production') {
                return 'Terjadi kesalahan: ' . $e->getMessage();
            }

            // Jika production, arahkan ke halaman error atau tampilkan pesan default
            return view('errors/html/error_404', ['message' => 'Gagal memuat dashboard.']);
        }
    }
}
