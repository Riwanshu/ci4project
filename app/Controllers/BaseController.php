<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Config\Services;

abstract class BaseController extends Controller
{
    protected $request;
    protected $session;
    protected $helpers = [];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // ✅ Start session
        $this->session = Services::session();

        // ✅ Set global cart count
        $cartCount = $this->getCartCount();
        $renderer = Services::renderer();
        $renderer->setVar('cart_count', $cartCount);
    }

    // ✅ Login check
    protected function checkLogin()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }
    }

    // ✅ Global cart count based on logged in user
    protected function getCartCount()
    {
        $user_id = $this->session->get('user_id') ?? 0;

        if ($user_id == 0) {
            return 0;
        }

        $cartModel = new \App\Models\CartModel();
        return $cartModel->where('user_id', $user_id)->countAllResults();
    }
}
