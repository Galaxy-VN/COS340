<?php
require_once 'app/config/database.php';
require_once 'app/models/ProductModel.php';
require_once 'app/models/CategoryModel.php';

class DefaultController
{
    public function index() {
        $db = (new Database())->getConnection();
        $productModel = new ProductModel($db);
        $categoryModel = new CategoryModel($db);
        
        $products = $productModel->getProducts();
        $categories = $categoryModel->getCategories();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $username = $_SESSION['username'] ?? 'guest';
        $cartItems = $_SESSION['cart_' . $username] ?? [];
        $cartCount = 0;
        foreach ($cartItems as $item) {
            $cartCount += (int)($item['quantity'] ?? 0);
        }
        
        include 'app/views/default/index.php';
    }
}