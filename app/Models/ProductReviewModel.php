<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductReviewModel extends Model
{
    protected $table      = 'product_reviews';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $useTimestamps = false; // Ubah ke true jika Anda punya kolom created_at & updated_at otomatis

    protected $allowedFields = [
        'orders_id',
        'products_id',
        'comment',
        'created_at',
    ];

    // Jika ingin format datetime otomatis (opsional)
    protected $dateFormat = 'datetime';
}
