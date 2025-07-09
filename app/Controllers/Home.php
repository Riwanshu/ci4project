<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CartModel;

class Home extends BaseController
{
    public function index()
    {
        if ($response = $this->checkLogin()) return $response;
        $productModel = new ProductModel();
        $data['products'] = $productModel->findAll();
        return view('welcome_message', $data);
    }

    public function about()
    {
        if ($response = $this->checkLogin()) return $response;
        return view('about');
    }

    public function contact()
    {
        if ($response = $this->checkLogin()) return $response;
        return view('contact');
    }

    public function men()
    {
        if ($response = $this->checkLogin()) return $response;
        $productModel = new ProductModel();
        $data['menproducts'] = $productModel->where('gender', 'male')->findAll();
        return view('men', $data);
    }

    public function women()
    {
        if ($response = $this->checkLogin()) return $response;
        $productModel = new ProductModel();
        $data['womenproducts'] = $productModel->where('gender', 'female')->findAll();
        return view('women', $data);
    }

    public function addToCart()
    {
        if ($response = $this->checkLogin()) return $response;
        $user_id   = session()->get('user_id');
        $productId = $this->request->getPost('product_id');
        $quantity  = $this->request->getPost('quantity');

        $productModel = new ProductModel();
        $cartModel    = new CartModel();
        $product      = $productModel->find($productId);

        if ($product && isset($product['id'])) {
            $cartModel->insert([
                'user_id'    => $user_id,
                'product_id' => $product['id'],
                'name'       => $product['name'],
                'price'      => $product['price'],
                'image'      => $product['image'],
                'quantity'   => $quantity,
            ]);
        } else {
            return redirect()->back()->with('error', 'Product not found or invalid');
        }

        return redirect()->to('/cart');
    }

    public function cart()
    {
        if ($response = $this->checkLogin()) return $response;
        $user_id = session()->get('user_id');

        $db = \Config\Database::connect();
        $builder = $db->table('carts');
        $builder->select('carts.*, products.name, products.image, products.price, products.discount');
        $builder->join('products', 'products.id = carts.product_id');
        $builder->where('carts.user_id', $user_id);

        $cartItems = $builder->get()->getResultArray();
        $couponPercent = session()->getFlashdata('coupon_percent') ?? 0;

        return view('cart', [
            'cart' => $cartItems,
            'coupon_percent' => $couponPercent,
            'cart_count' => count($cartItems)
        ]);
    }

    public function removeFromCart($id)
    {
        if ($response = $this->checkLogin()) return $response;
        $cartModel = new CartModel();
        $cartModel->delete($id);
        return redirect()->to('/cart');
    }

    public function applyCoupon()
    {
        if ($response = $this->checkLogin()) return $response;
        $couponCode = $this->request->getPost('coupon_code');

        $coupons = [
            'SAVE10' => 10,
            'SAVE25' => 25,
            'HALFOFF' => 50,
        ];

        if (array_key_exists($couponCode, $coupons)) {
            session()->setFlashdata('coupon_percent', $coupons[$couponCode]);
            session()->setFlashdata('applied_coupon', $couponCode);
        } else {
            session()->setFlashdata('coupon_error', 'Invalid coupon code');
        }

        return redirect()->to('/cart');
    }

    public function placeOrder()
    {
        if ($response = $this->checkLogin()) return $response;
        $user_id      = session()->get('user_id');
        $cartModel    = new CartModel();
        $orderModel   = new \App\Models\OrderModel();
        $productModel = new ProductModel();

        $cartItems = $cartModel->where('user_id', $user_id)->findAll();

        foreach ($cartItems as $item) {
            $existingOrder = $orderModel->where([
                'user_id'    => $user_id,
                'product_id' => $item['product_id']
            ])->first();

            $product  = $productModel->find($item['product_id']);
            $discount = $product['discount'] ?? 0;

            $orderData = [
                'user_id'     => $user_id,
                'product_id'  => $item['product_id'],
                'name'        => $item['name'],
                'subtotal'    => $this->request->getPost('subtotal'),
                'delivery'    => $this->request->getPost('delivery'),
                'discount'    => $discount,
                'coupon'      => $this->request->getPost('coupon_discount'),
                'total'       => $this->request->getPost('grand_total'),
            ];

            if ($existingOrder) {
                $orderModel->update($existingOrder['id'], $orderData);
            } else {
                $orderModel->insert($orderData);
            }
        }

        return redirect()->to('/checkout');
    }

    public function checkout()
    {
        if ($response = $this->checkLogin()) return $response;
        $user_id = session()->get('user_id');

        $cartModel = new CartModel();
        $checkoutModel = new \App\Models\CheckoutModel();
        $productModel = new ProductModel();

        $db = \Config\Database::connect();
        $builder = $db->table('carts');
        $builder->select('carts.*, products.name, products.image, products.price, products.discount');
        $builder->join('products', 'products.id = carts.product_id');
        $builder->where('carts.user_id', $user_id);
        $cartItems = $builder->get()->getResultArray();

        $subtotal = 0;
        $totalBeforeDiscount = 0;
        $totalDiscount = 0;

        foreach ($cartItems as $item) {
            $price     = (float) $item['price'];
            $discount  = isset($item['discount']) ? (float) $item['discount'] : 0;
            $quantity  = (int) $item['quantity'];
            $discountAmount = ($price * $discount) / 100;
            $discountedPrice = $price - $discountAmount;
            $itemTotal = $discountedPrice * $quantity;

            $subtotal += $itemTotal;
            $totalDiscount += $discountAmount * $quantity;
            $totalBeforeDiscount += $price * $quantity;
        }

        $delivery = ($totalBeforeDiscount > 500) ? 0 : 50;
        $couponPercent = session()->getFlashdata('coupon_percent') ?? 0;
        $couponDiscount = ($subtotal * $couponPercent) / 100;
        $grandTotal = $subtotal + $delivery - $totalDiscount - $couponDiscount;

        $checkout = $checkoutModel->where('user_id', $user_id)->orderBy('id', 'desc')->first();

        return view('checkout', [
            'cart'            => $cartItems,
            'checkout'        => $checkout,
            'subtotal'        => $subtotal,
            'delivery'        => $delivery,
            'total_discount'  => $totalDiscount,
            'coupon_discount' => $couponDiscount,
            'coupon_percent'  => $couponPercent,
            'grand_total'     => $grandTotal,
        ]);
    }

    public function orderComplete()
    {
        if ($response = $this->checkLogin()) return $response;
        return view('order-complete');
    }

    public function wishlist()
    {
        if ($response = $this->checkLogin()) return $response;
        return view('add-to-wishlist');
    }

    public function productDetail($id)
    {
        if ($response = $this->checkLogin()) return $response;
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Product not found");
        }

        return view('product-detail', ['product' => $product]);
    }
}
