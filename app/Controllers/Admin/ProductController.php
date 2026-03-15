<?php 

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;  // Mengubah referensi ke CategoryModel
use App\Models\ProductModel;

class ProductController extends BaseController
{
    protected $categoryModel, $productModel;
    public function __construct()
    {
        $this->categoryModel = new CategoryModel();  // Menggunakan CategoryModel
        $this->productModel = new ProductModel();
    }

    // Menampilkan daftar produk
    public function index()
    {
        $data['categories'] = $this->categoryModel->findAll();

        $data['products'] = $this->productModel
            ->withDeleted() 
            ->select('products.*, category_product.nama_category as category_nama_category')
            ->join('category_product', 'category_product.id = products.category_id', 'left')
            ->where('category_product.deleted_at', null)
            ->findAll();

        return view('admin/product/index', $data);
    }


    // Menampilkan form tambah produk
    public function create()
    {
        $data['categories'] = $this->categoryModel->findAll();  // Mengambil kategori produk
        return view('admin/product/create', $data);
    }

    // Menyimpan produk baru
    public function store()
    {
        $validation = \Config\Services::validation();
        $data = $this->request->getPost();
        $validate = $this->validate([
            'name'        => 'required|min_length[3]|max_length[255]|is_unique[products.name]',
            'price'       => 'required|decimal',
            'stock'       => 'required|integer',
            'category_id' => 'required|integer',
        ]);

        // Validasi data produk
        if (!$validate)  return redirect()->back()->withInput()->with('validation', $validation->getErrors());

        // Menangani upload gambar
        $image = $this->request->getFile('image');
        if ($image && $image->isValid()) {
            $imageName = $image->getRandomName();
            $image->move('uploads/products', $imageName);
        }

        $this->productModel->save([
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'price'       => $data['price'],
            'stock'       => $data['stock'],
            'image'       => $imageName ?? null,
            'category_id' => $data['category_id'],
        ]);

        return redirect()->to('/admin/products')->with('success_message', 'Product added successfully.');
    }

    public function edit($id)
    {

        // Ambil data produk berdasarkan ID
        $product = $this->productModel->find($id);
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Produk dengan ID $id tidak ditemukan.");
        }

        // Ambil data kategori untuk dropdown
        $categories = $this->categoryModel->findAll();

        $data = [
            'title' => 'Edit Produk',
            'product' => $product,
            'categories' => $categories
        ];

        return view('admin/product/edit', $data);
    }

    public function update($id)
    {
        // Validasi input
        if (!$this->validate([
            'name' => 'required|min_length[3]|max_length[255]',
            'category_id' => 'required|integer',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'is_image[image]|max_size[image,2048]|mime_in[image,image/png,image/jpeg,image/jpg]'
        ])) {
            return redirect()->to('admin/product/edit/' . $id)->withInput()->with('validation', \Config\Services::validation()->getErrors());
        }

        // Ambil data produk lama
        $product = $this->productModel->find($id);
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Produk dengan ID $id tidak ditemukan.");
        }

        // Proses upload gambar baru (jika ada)
        $image = $this->request->getFile('image');
        if ($image->isValid() && !$image->hasMoved()) {
            $newImageName = $image->getRandomName();
            $image->move('uploads/products/', $newImageName);

            // Hapus gambar lama jika ada
            if (!empty($product['image']) && file_exists('uploads/products/' . $product['image'])) {
                unlink('uploads/products/' . $product['image']);
            }
        } else {
            $newImageName = $product['image']; // Gunakan gambar lama jika tidak ada upload baru
        }

        // Update data di database
        $this->productModel->update($id, [
            'name' => $this->request->getPost('name'),
            'category_id' => $this->request->getPost('category_id'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'description' => $this->request->getPost('description'),
            'image' => $newImageName
        ]);

        session()->setFlashdata('success_message', 'Produk berhasil diperbarui.');
        return redirect()->to('admin/products');
    }

    // Menghapus produk
    public function delete($id)
    {
        // Menghapus    Produk berdasarkan ID
        if ($this->productModel->delete($id)) {
            session()->setFlashdata('success_message', '    Produk berhasil dihapus.');
        } else {
            session()->setFlashdata('error_message', 'Terjadi kesalahan saat menghapus  Produk.');
        }

        return redirect()->to('admin/products');
    }

    public function toggle($id)
    {
        $action = $this->request->getPost('action');

        $product = $this->productModel->withDeleted()->find($id);

        if (!$product) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Produk tidak ditemukan.'
            ])->setStatusCode(404);
        }

        if ($action === 'nonaktif') {
            $this->productModel->delete($id); // soft delete
            $message = 'Produk berhasil dinonaktifkan.';
        } elseif ($action === 'aktif') {
            $this->productModel->restore($id); // panggil method restore
            $message = 'Produk berhasil diaktifkan kembali.';
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Aksi tidak valid.'
            ])->setStatusCode(400);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => $message
        ]);
    }

    public function all()
    {
        $products = $this->productModel->findAll();
        return $this->response->setJSON(['success' => true, 'products' => $products]);
    }

}
