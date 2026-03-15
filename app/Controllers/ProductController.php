<?php

namespace App\Controllers;

use App\Models\CartItemModel;
use App\Models\CartModel;
use App\Models\ProductBannerModel;
use App\Models\ProductModel;

class ProductController extends BaseController
{
    protected $productModel, $productBannerModel, $cartModel, $cartItemModel;
    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->productBannerModel = new ProductBannerModel();
        $this->cartModel = new CartModel();
        $this->cartItemModel = new CartItemModel();
    }

    public function index()
    {
        $category = $this->request->getGet('category');

        if ($category) {
            $products = $this->productModel->where('category_id', $category)->findAll();
        } else {
            $products = $this->productModel->findAll();
        }

        return $this->response->setJSON(['products' => $products, 'category' => $category]);
    }

    public function banners()
    {
        $banners = $this->productBannerModel->findAll();

        return json_encode(['banners' => $banners]);
    }

    public function search()
    {
        $keyword = $this->request->getGet('q');

        if (!$keyword) {
            return ['status' => 'ERROR', 'message' => 'Keyword tidak boleh kosong'];
        }
        $products = $this->productModel->like('name', $keyword)->findAll();

        return json_encode(['products' => $products]);
    }

    public function getcart($id)
    {
        // Jika ID valid (bukan 0), ambil dari database
        if ($id != 0) {
            $cookie = $this->request->getCookie('cart');
            $cartCookie = json_decode($cookie, true);

            if ($cartCookie || !empty($cartCookie))  $this->storeCart($cartCookie);

            $carts = $this->cartModel
                ->select('carts.id, carts.session_id, carts.total, cart_items.id as items_id,cart_items.product_id, cart_items.qty, cart_items.subtotal, cart_items.notes, products.name, products.description') // Tambahkan cart_items.notes
                ->join('cart_items', 'cart_items.cart_id = carts.id', 'left')
                ->join('products', 'cart_items.product_id = products.id', 'left')
                ->where('carts.session_id', $id)
                ->findAll();

            return $this->response->setJSON(['status' => 'OK', 'carts' => $carts]);

        }

        // Kalau ID = 0, ambil cart dari cookie
        $request = service('request');
        $cookieCart = $request->getCookie('cart');
        $cart = json_decode($cookieCart, true);
        $cartWithDetail = [];

        if (!$cart || empty($cart)) {
            return $this->response->setJSON(['status' => 'OK', 'carts' => $cartWithDetail]);
        }

        foreach ($cart as $item) {
            $product = $this->productModel->find($item['product_id']);
            $cartWithDetail[] = [
                'product_id' => $item['product_id'],
                'qty' => $item['quantity'],
                'subtotal' => $item['quantity'] * ($product['price'] ?? 0),
                'name' => $product['name'] ?? 'Unknown',
                'description' => $product['description'] ?? '-',
                'notes' => $item['notes'] ?? '', // Tambahkan notes
                'total' => array_sum(array_column($cart, 'subtotal')),
            ];
        }

        return $this->response->setJSON(['status' => 'OK', 'carts' => $cartWithDetail]);
    }

    private function storeCart($cartCookie)
    {
        $this->cartModel->save([
            'session_id' => session('session')['table_id'],
            'total'      => array_sum(array_column($cartCookie, 'subtotal')),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null
        ]);
        $cartID = $this->cartModel->insertID();

        foreach ($cartCookie as $item) {
            $this->cartItemModel->save([
                'cart_id'     => $cartID,
                'product_id'  => $item['product_id'],
                'qty'         => $item['quantity'],
                'subtotal'    => $item['subtotal'],
                'notes'       => $item['notes'] ?? '', // Tambahkan notes
            ]);
        }

        $this->response->setCookie('cart', '', time() - 3600);
    }

    public function addcart($id)
    {
        try {
            // 1) Ambil produk
            $product = $this->productModel->asObject()->find($id);
            if (!$product) {
                return $this->response->setJSON(['status' => 'ERROR', 'message' => 'Produk tidak ditemukan'])->setStatusCode(404);
            }

            // 2) Ambil & validasi qty
            $qty = (int) $this->request->getPost('qty');
            if ($qty < 1) { $qty = 1; }

            $notes = $this->request->getPost('notes') ?? ''; // Tambahkan pengambilan notes

            $harga = (float) $product->price;
            $sessionID = session('session')['table_id'] ?? null;

            // 3) MODE COOKIE (tanpa session)
            if (!$sessionID) {
                $cartCookieRaw = $this->request->getCookie('cart');
                $cartCookie = json_decode($cartCookieRaw ?? '[]', true);
                if (!is_array($cartCookie)) { $cartCookie = []; }

                $found = false;
                foreach ($cartCookie as &$item) {
                    if ((int)$item['product_id'] === (int)$id) {
                        $item['quantity'] = (int)$item['quantity'] + $qty;
                        $item['subtotal'] = $item['quantity'] * $harga;
                        $found = true;
                        break;
                    }
                }
                unset($item);

                if (!$found) {
                    $cartCookie[] = [
                        'product_id' => (int) $id,
                        'quantity'   => $qty,
                        'subtotal'   => $harga * $qty,
                        'notes'      => $notes, // Tambahkan notes
                    ];
                }

                return $this->response
                    ->setCookie('cart', json_encode($cartCookie), 3600, '', '/', '', false, true, 'Lax')
                    ->setJSON(['status' => 'OK', 'product' => (int)$id]);
            }

            $this->db->transStart();

            // Pastikan ambil sebagai object
            $cart = $this->cartModel->asObject()->where('session_id', $sessionID)->first();

            if (!$cart) {
                $this->cartModel->save([
                    'session_id' => $sessionID,
                    'total'      => 0,
                ]);
                $cartID = $this->cartModel->getInsertID();
                $cart   = $this->cartModel->asObject()->find($cartID);
            }

            // Upsert item cart
            $cartItem = $this->cartItemModel
                ->asObject()
                ->where('cart_id', $cart->id)
                ->where('product_id', $id)
                ->first();

            if ($cartItem) {
                $newQty = (int)$cartItem->qty + $qty;
                $this->cartItemModel->update($cartItem->id, [
                    'qty'      => $newQty,
                    'subtotal' => $newQty * $harga,
                ]);
            } else {
                $this->cartItemModel->save([
                    'cart_id'    => $cart->id,
                    'product_id' => $id,
                    'qty'        => $qty,
                    'subtotal'   => $harga * $qty,
                    'notes'      => $notes, // Tambahkan notes
                ]);
            }

            // Hitung ulang total
            $totalHarga = (float) ($this->cartItemModel
                ->selectSum('subtotal')
                ->where('cart_id', $cart->id)
                ->get()
                ->getRow()
                ->subtotal ?? 0);

            $this->cartModel->update($cart->id, ['total' => $totalHarga]);

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \RuntimeException('Gagal menyimpan cart.');
            }

            return $this->response->setJSON(['status' => 'OK', 'product' => (int)$id]);

        } catch (\Throwable $e) {
            log_message('error', 'addcart error: {msg}', ['msg' => $e->getMessage()]);
            return $this->response->setJSON([
                'status'  => 'ERROR',
                'message' => 'Terjadi kesalahan. Coba lagi.'
            ])->setStatusCode(500);
        }
    }

    public function updatecartitem($itemId)
    {
        try {
            $notes = $this->request->getPost('notes') ?? '';
            $qty = (int) $this->request->getPost('qty') ?? null;

            $sessionID = session('session')['table_id'] ?? null;

            if (!$sessionID) {
                // Mode cookie: belum diimplementasi, tapi bisa tambahkan jika perlu
                return $this->response->setJSON(['status' => 'ERROR', 'message' => 'Update tidak didukung di mode cookie'])->setStatusCode(400);
            }

            $this->db->transStart();

            $cart = $this->cartModel->asObject()->where('session_id', $sessionID)->first();
            if (!$cart) {
                return $this->response->setJSON(['status' => 'ERROR', 'message' => 'Keranjang tidak ditemukan'])->setStatusCode(404);
            }

            $cartItem = $this->cartItemModel->asObject()->where('id', $itemId)->where('cart_id', $cart->id)->first();
            if (!$cartItem) {
                return $this->response->setJSON(['status' => 'ERROR', 'message' => 'Item tidak ditemukan'])->setStatusCode(404);
            }

            $product = $this->productModel->asObject()->find($cartItem->product_id);
            if (!$product) {
                return $this->response->setJSON(['status' => 'ERROR', 'message' => 'Produk tidak ditemukan'])->setStatusCode(404);
            }

            $updateData = [];
            if ($qty !== null && $qty > 0) {
                $updateData['qty'] = $qty;
                $updateData['subtotal'] = $qty * (float) $product->price;
            }
            if (isset($notes)) {
                $updateData['notes'] = $notes;
            }

            if (!empty($updateData)) {
                $this->cartItemModel->update($itemId, $updateData);
            }

            // Hitung ulang total
            $totalHarga = (float) ($this->cartItemModel
                ->selectSum('subtotal')
                ->where('cart_id', $cart->id)
                ->get()
                ->getRow()
                ->subtotal ?? 0);

            $this->cartModel->update($cart->id, ['total' => $totalHarga]);

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \RuntimeException('Gagal update item.');
            }

            return $this->response->setJSON(['status' => 'OK', 'message' => 'Item berhasil diupdate']);

        } catch (\Throwable $e) {
            log_message('error', 'updatecartitem error: {msg}', ['msg' => $e->getMessage()]);
            return $this->response->setJSON([
                'status'  => 'ERROR',
                'message' => 'Terjadi kesalahan. Coba lagi.'
            ])->setStatusCode(500);
        }
    }

    public function deleteItem($id)
    {
        $id = (int) $id;

        $sessionData = session('session') ?? [];
        $sessionID   = $sessionData['table_id'] ?? null;

        // COOKIE MODE
        if (!$sessionID) {
            $request     = service('request');
            $cartCookie  = json_decode($request->getCookie('cart') ?? '[]', true);
            if (!is_array($cartCookie)) $cartCookie = [];

            // Di cookie mode: anggap $id = product_id
            $updatedCart = array_values(array_filter($cartCookie, static function ($item) use ($id) {
                return (int)($item['product_id'] ?? 0) !== $id;
            }));

            $totalHarga = array_sum(array_map(static fn($i) => (float)($i['subtotal'] ?? 0), $updatedCart));

            return $this->response
                ->setCookie([
                    'name'     => 'cart',
                    'value'    => json_encode($updatedCart, JSON_UNESCAPED_UNICODE),
                    'expire'   => 3600,
                    'path'     => '/',
                    'secure'   => false,
                    'httponly' => true,
                    'samesite' => 'Lax',
                ])
                ->setJSON([
                    'status'    => 'OK',
                    'message'   => 'Item removed from cart',
                    'new_total' => $totalHarga
                ]);
        }

        // DB MODE
        $db = \Config\Database::connect();
        $db->transStart();

        $cart = $this->cartModel->asObject()
            ->where('session_id', $sessionID)
            ->first();

        if (!$cart) {
            $db->transComplete();
            return $this->response->setStatusCode(404)
                ->setJSON(['status' => 'ERR', 'message' => 'Cart not found']);
        }

        $cartItem = $this->cartItemModel->asObject()
            ->where('cart_id', $cart->id)
            ->groupStart()
                ->where('id', $id)
                ->orWhere('product_id', $id)
            ->groupEnd()
            ->first();

        if (!$cartItem) {
            $db->transComplete();
            return $this->response->setStatusCode(404)
                ->setJSON(['status' => 'ERR', 'message' => 'Item not found']);
        }

        $this->cartItemModel->delete($cartItem->id);

        // Recompute total
        $totalHarga = (float) ($this->cartItemModel
            ->selectSum('subtotal')
            ->where('cart_id', $cart->id)
            ->get()
            ->getRow()
            ->subtotal ?? 0);

        if ($totalHarga <= 0) $this->cartModel->delete($cart->id);
        else $this->cartModel->update($cart->id, ['total' => $totalHarga]);

        $db->transComplete();
        if ($db->transStatus() === false) {
            return $this->response->setStatusCode(500)
                ->setJSON(['status' => 'ERR', 'message' => 'Failed to update cart']);
        }

        return $this->response->setJSON([
            'status'    => 'OK',
            'message'   => 'Item deleted successfully',
            'new_total' => $totalHarga
        ]);
    }
    
}
