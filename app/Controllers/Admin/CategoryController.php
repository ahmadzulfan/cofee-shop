<?php 

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }


    public function index()
    {
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->withDeleted()->findAll();
        return view('admin/category/index', $data);  // Menampilkan kategori produk di view
    }

    public function create()
    {
        return view('admin/category/create');
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nama_category' => 'required|min_length[3]|max_length[255]|is_unique[category_product.nama_category]',
            'image' => 'permit_empty|is_image[image]|max_size[image,2048]|mime_in[image,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('admin/category-product/create')
                            ->withInput()
                            ->with('validation', $validation->getErrors());
        }

        $imageFile = $this->request->getFile('image');
        $imageName = null;

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            // Pastikan folder ada
            if (!is_dir('uploads/category')) {
                mkdir('uploads/category', 0755, true);
            }
            
            $imageName = $imageFile->getRandomName();
            $imageFile->move('uploads/category', $imageName);
        }

        $categoryModel = new CategoryModel();
        $categoryModel->save([
            'nama_category' => $this->request->getPost('nama_category'),
            'image' => $imageName,
        ]);

        session()->setFlashdata('success_message', 'Kategori berhasil ditambahkan.');
        return redirect()->to('admin/category-product');
    }

    public function edit($id)
    {
        $categoryModel = new CategoryModel();
        $category = $categoryModel->find($id);

        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        // ✅ Tampilkan form edit
        return view('admin/category/edit', ['category' => $category]);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nama_category' => 'required|min_length[3]|max_length[255]|is_unique[category_product.nama_category,id,' . $id . ']',
            'image' => 'permit_empty|is_image[image]|max_size[image,2048]|mime_in[image,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('admin/category-product/edit/' . $id)
                            ->withInput()
                            ->with('validation', $validation->getErrors());
        }

        $categoryModel = new CategoryModel();
        $category = $categoryModel->find($id);

        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        $imageFile = $this->request->getFile('image');
        $imageName = $category['image'];

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            // Hapus gambar lama jika ada
            if (!empty($imageName) && file_exists('uploads/category/' . $imageName)) {
                unlink('uploads/category/' . $imageName);
            }

            // Pastikan folder ada
            if (!is_dir('uploads/category')) {
                mkdir('uploads/category', 0755, true);
            }

            $imageName = $imageFile->getRandomName();
            $imageFile->move('uploads/category', $imageName);
        }

        $categoryModel->update($id, [
            'nama_category' => $this->request->getPost('nama_category'),
            'image' => $imageName,
        ]);

        session()->setFlashdata('success_message', 'Kategori berhasil diperbarui.');
        return redirect()->to('admin/category-product');
    }

    public function delete($id)
    {
        $categoryModel = new CategoryModel();
        $category = $categoryModel->find($id);

        if ($category && !empty($category['image']) && file_exists('uploads/category/' . $category['image'])) {
            // ✅ Hapus file gambar jika ada
            unlink('uploads/category/' . $category['image']);
        }

        if ($categoryModel->delete($id)) {
            session()->setFlashdata('success_message', 'Kategori berhasil dihapus.');
        } else {
            session()->setFlashdata('error_message', 'Terjadi kesalahan saat menghapus kategori.');
        }

        return redirect()->to('admin/category-product');
    }

    public function toggle($id)
    {
        $action = $this->request->getPost('action');

        // Ambil kategori termasuk yang sudah dihapus (soft delete)
        $category = $this->categoryModel->withDeleted()->find($id);

        if (!$category) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kategori tidak ditemukan.'
            ])->setStatusCode(404);
        }

        $productModel = new \App\Models\ProductModel();

        if ($action === 'nonaktif') {
            $this->categoryModel->delete($id); // Soft delete kategori
            // Soft delete semua produk dalam kategori ini
            $products = $productModel->where('category_id', $id)->findAll();
            foreach ($products as $product) {
                $productModel->delete($product['id']); // Soft delete produk
            }
            $message = 'Kategori dan semua produk di dalamnya berhasil dinonaktifkan.';
        } elseif ($action === 'aktif') {
            $this->categoryModel->restore($id); // Restore kategori
            // (Opsional) Restore semua produk dalam kategori ini
            $products = $productModel->withDeleted()->where('category_id', $id)->findAll();
            foreach ($products as $product) {
                $productModel->update($product['id'], ['deleted_at' => null]);
            }
            $message = 'Kategori berhasil diaktifkan kembali.';
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


}
