<?php 

namespace App\Controllers\Admin;

use App\Models\ProductReviewModel;
use App\Models\ReviewModel;

class ReviewController extends BaseController
{
    protected $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new ProductReviewModel();
    }

    public function index()
    {
        $data['reviews'] = $this->reviewModel->join('orders', 'orders.id = product_reviews.order_id')->asObject()->findAll();  // Mengambil semua data kategori produk
        return view('admin/reviews/index', $data);  // Menampilkan kategori produk di view
    }

    public function delete($id)
    {

        // Menghapus kategori berdasarkan ID
        if ($this->reviewModel->delete($id)) {
            session()->setFlashdata('success_message', 'Kategori berhasil dihapus.');
        } else {
            session()->setFlashdata('error_message', 'Terjadi kesalahan saat menghapus kategori.');
        }

        return redirect()->to('admin/reviews');
    }

}
