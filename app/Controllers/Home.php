<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ProductReviewModel;
use App\Models\ReviewModel;

class Home extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();

        // Hitung view unik per IP per hari
        $ip = $this->request->getIPAddress();
        $today = date('Y-m-d');

        $exists = $db->table('website_views')
            ->where('ip_address', $ip)
            ->where('DATE(viewed_at)', $today)
            ->countAllResults();

        if ($exists == 0) {
            // Tambah ke total_views
            $db->table('view_counter')
                ->where('id', 1)
                ->set('total_views', 'total_views+1', false)
                ->update();

            // Simpan log pengunjung
            $db->table('website_views')->insert([
                'ip_address' => $ip,
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
            ]);
        }

        // 🔽 Tambahan: Ambil semua produk
        $products = $db->table('products')->get()->getResultArray();

        // Kirim data produk ke view
        return view('customer/index.php', ['products' => $products]);
    }


    public function show($id)
    {
        
        // Ambil data produk berdasarkan ID
        $productModel = new ProductModel();
        $reviewModel = new ProductReviewModel();
        $data['title'] = 'Deskripsi Produk';
        $data['product'] = $productModel->asObject()->find($id);
        $data['reviews'] = $reviewModel->join('orders', 'orders.id = product_reviews.order_id')->asObject()->where('product_id', $id)->findAll();
        return view('customer/food/index.php', $data);
    }

    public function contactUs(): string
    {
        $data['title'] = 'Kontak Kami';
        return view('customer/contact_us.php', $data);
    }

    public function faq(): string
    {
        $data['title'] = 'FAQ';
        return view('customer/faq.php', $data);
    }

    public function menu() {
        return view('customer/menu');
    }

    public function keranjang() {
        return view('customer/keranjang');
    }
}
