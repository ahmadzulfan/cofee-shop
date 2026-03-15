<?php

namespace App\Models;

use CodeIgniter\Model;

class TableModel extends Model
{
    protected $table = 'tables';
    protected $primaryKey = 'id';
    protected $allowedFields = ['table_number', 'status'];

    public function getTables()
    {
        return $this->findAll();
    }

    public function getTableById($id)
    {
        return $this->where('id', $id)->first();
    }
}
