<?php

namespace App\Controllers;

use App\Models\CartItemModel;
use App\Models\CartModel;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    protected $categoryModel, $cartModel, $cartItemModel;
    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->cartModel = new CartModel();
        $this->cartItemModel = new CartItemModel();
    }

    public function index()
    {
        $model = new CategoryModel();
        $categories = $model->findAll();
        return $this->response->setJSON(['categories' => $categories]);
    }
}
