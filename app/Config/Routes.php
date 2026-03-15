<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('auth', ['filter' => 'redirectIfLoggedIn'], function($routes){
    $routes->get('login', 'AuthController::login');
    $routes->get('login/(:segment)', 'AuthController::dologin/$1');
});
    //CUSTOMER
    $routes->get('/', 'Home::index');
    $routes->get('menu', 'Home::menu');
    $routes->get('keranjang', 'Home::keranjang');
    $routes->get('auth/logout', 'AuthController::logout');
    $routes->get('/product/(:num)', 'Home::show/$1');
    $routes->get('/kontak-kami', 'Home::contactUs');
    $routes->get('/faq', 'Home::faq');
    $routes->get('/checkout', 'OrderController::checkout');
    $routes->post('/checkout', 'OrderController::prosesCheckout');
    $routes->post('order/review/(:num)/(:num)', 'OrderController::submitProductReview/$1/$2');
    $routes->get('/order/(:num)', 'OrderController::order/$1');
    $routes->get('order/struk/(:num)', 'OrderController::strukPDF/$1');
    $routes->group('api', function($routes) {
        $routes->post('updatecartitem/(:num)', 'ProductController::updatecartitem/$1');
        $routes->post('(:num)/order', 'PaymentController::order/$1');
        $routes->get('categories', 'CategoryController::index');
        $routes->get('products', 'ProductController::index');
        $routes->get('banners', 'ProductController::banners');
        $routes->post('(:num)/addcart', 'ProductController::addcart/$1');
        $routes->get('(:num)/getcart', 'ProductController::getcart/$1');
        $routes->post('(:num)/deleteitem', 'ProductController::deleteItem/$1');
        $routes->get('search', 'ProductController::search');
        $routes->get('get/qr/(:segment)', 'Admin\TableController::generateQr/$1');
        $routes->post('status/payment', 'PaymentController::updateStatus');
    });

    //ADMIN MENU
    $routes->group('admin', function($routes) {
        $routes->group('auth', function($routes){
            $routes->get('login', 'Admin\AuthController::login');
            $routes->post('login', 'Admin\AuthController::doLogin');
            $routes->post('logout', 'Admin\AuthController::logout');
        });
        
        $routes->group('', ['filter' => 'auth'], function($routes){
            $routes->get('/', 'Admin\DashboardController::index');
            $routes->get('my-account', 'Admin\AuthController::myAccount');
            $routes->post('my-account/ubah-password', 'Admin\AuthController::changePassword');
            $routes->get('products', 'Admin\ProductController::index');
            $routes->get('product/create', 'Admin\ProductController::create');
            $routes->post('product/store', 'Admin\ProductController::store');
            $routes->get('product/edit/(:num)', 'Admin\ProductController::edit/$1');
            $routes->post('product/update/(:num)', 'Admin\ProductController::update/$1');
            $routes->post('product/toggle/(:num)', 'Admin\ProductController::toggle/$1');
            $routes->post('product/delete/(:num)', 'Admin\ProductController::delete/$1');
        
            $routes->get('category-product', 'Admin\CategoryController::index');
            $routes->get('category-product/create', 'Admin\CategoryController::create');
            $routes->post('category-product/store', 'Admin\CategoryController::store');
            $routes->get('category-product/edit/(:num)', 'Admin\CategoryController::edit/$1');
            $routes->post('category-product/update/(:num)', 'Admin\CategoryController::update/$1');
            $routes->post('category-product/delete/(:num)', 'Admin\CategoryController::delete/$1');
            $routes->post('category-product/toggle/(:num)', 'Admin\CategoryController::toggle/$1');

            
            $routes->get('tables', 'Admin\TableController::index');
            $routes->get('tables/create', 'Admin\TableController::create');
            $routes->post('tables/store', 'Admin\TableController::store');
            $routes->get('tables/edit/(:num)', 'Admin\TableController::edit/$1');
            $routes->post('tables/update/(:num)', 'Admin\TableController::update/$1');
            $routes->get('tables/delete/(:num)', 'Admin\TableController::delete/$1');
        
            $routes->group('orders', function($routes){
                $routes->get('', 'Admin\OrderController::index');
                $routes->post('(:num)/paycash', 'Admin\OrderController::payCash/$1');
                $routes->post('(:num)/complete', 'Admin\OrderController::completeOrder/$1');
                $routes->get('get_detail/(:num)', 'Admin\OrderController::get_detail/$1');
                $routes->post('delete/(:num)', 'Admin\OrderController::delete/$1');
                $routes->post('update_items', 'Admin\OrderController::update_items');
                $routes->get('riwayat', 'Admin\OrderController::riwayat');
            });

            $routes->group('products', function($routes){
                $routes->get('all', 'Admin\ProductController::all');
            });

            $routes->group('payments', function($routes){
                $routes->get('', 'Admin\PaymentController::index');
                $routes->post('delete/(:num)', 'Admin\PaymentController::delete/$1');
            });

            $routes->group('keuangan', function($routes){
                $routes->get('dana_kas', 'Admin\KeuanganController::index');
                $routes->get('dana_masuk', 'Admin\KeuanganController::indexMasuk');
                $routes->get('dana_keluar', 'Admin\KeuanganController::indexKeluar');
                $routes->post('expense/store', 'Admin\KeuanganController::storeExpense');
                $routes->get('ekspor', 'Admin\KeuanganController::exportPdf');
                $routes->get('ekspor/pemasukan', 'Admin\KeuanganController::exportPdfPemasukan');
                $routes->get('ekspor/pengeluaran', 'Admin\KeuanganController::exportPdfPengeluaran');
            });

            $routes->group('reviews', function($routes){
                $routes->get('', 'Admin\ReviewController::index');
                $routes->post('delete/(:num)', 'Admin\ReviewController::delete/$1');
            });

            $routes->group('users', function ($routes) {
            $routes->get('', 'Admin\UserController::index');
            $routes->get('create', 'Admin\UserController::create');
            $routes->post('store', 'Admin\UserController::store');
            $routes->get('edit/(:num)', 'Admin\UserController::edit/$1');
            $routes->post('update/(:num)', 'Admin\UserController::update/$1');
            $routes->get('delete/(:num)', 'Admin\UserController::delete/$1');
            });

            $routes->group('setting/payment', function($routes){
                $routes->get('', 'Admin\SettingController::payment');
                $routes->post('', 'Admin\SettingController::updatePayment');
            });
        });
    });

