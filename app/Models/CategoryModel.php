<?php namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table      = 'category_product';  // Nama tabel tetap 'category_product'
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';


    protected $allowedFields = ['nama_category','image', 'deleted_at'];

    public function restore($id)
    {
        return $this->withDeleted()->update($id, ['deleted_at' => null]);
    }

    public function onlyActive()
    {
        return $this->where('deleted_at', null);
    }

    // Menambahkan validation rules jika diperlukan
    protected $validationRules = [
        'nama_category' => 'required|min_length[3]|max_length[255]',
    ];

    protected $validationMessages = [];
}
