<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('login', 'Login::index');        // ✅ Shows login form
$routes->post('login', 'Login::auth');        // ✅ Handles login form submission
$routes->get('logout', 'Login::logout');      // ✅ Logout route


$routes->get('/', 'Home::index');
$routes->get('index', 'Home::index');
$routes->get('about', 'Home::about');
$routes->get('contact', 'Home::contact');
$routes->get('men', 'Home::men');
$routes->get('women', 'Home::women');
$routes->get('cart', 'Home::cart');
$routes->post('cart', 'Home::addToCart'); // ✅ ADD THIS LINE
$routes->match(['get', 'post'], 'checkout', 'Home::checkout');
$routes->get('order-complete', 'Home::orderComplete');
$routes->get('add-to-wishlist', 'Home::wishlist');
$routes->get('product-detail/(:num)', 'Home::productDetail/$1');
$routes->post('cart/apply-coupon', 'Home::applyCoupon');
$routes->get('cart/remove/(:num)', 'Home::removeFromCart/$1');
$routes->post('place-order', 'Home::placeOrder');
