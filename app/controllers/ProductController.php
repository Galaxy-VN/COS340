<?php
require_once 'app/config/database.php';
require_once 'app/models/ProductModel.php';
require_once 'app/models/CategoryModel.php';
require_once 'app/models/OrderModel.php';

class ProductController
{
    private $productModel;
    private $categoryModel;
    private $orderModel;
    private $db;

    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
        $this->categoryModel = new CategoryModel($this->db);
        $this->orderModel = new OrderModel($this->db);
    }

    private function getCartKey(): string
    {
        $username = $_SESSION['username'] ?? 'guest';
        return 'cart_' . $username;
    }

    private function getCart(): array
    {
        $key = $this->getCartKey();
        return $_SESSION[$key] ?? [];
    }

    private function saveCart(array $cart): void
    {
        $key = $this->getCartKey();
        $_SESSION[$key] = $cart;
    }

    private function getCartCount(): int
    {
        $count = 0;
        foreach ($this->getCart() as $item) {
            $count += (int) ($item['quantity'] ?? 0);
        }
        return $count;
    }

    private function setFlash(string $message, string $type = 'success'): void
    {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
    }

    private function redirectTo(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }

    private function checkAdmin(): void
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $this->redirectTo('/phamgiahuy/Product');
        }
    }

    public function index()
    {
        $categories = $this->categoryModel->getCategories();
        $products = $this->productModel->getProducts();
        $cartCount = $this->getCartCount();
        include 'app/views/product/list.php';
    }

    public function category($categoryId)
    {
        $categories = $this->categoryModel->getCategories();
        $category = $this->categoryModel->getCategoryById($categoryId);
        if (!$category) {
            http_response_code(404);
            die('Category not found');
        }
        $products = $this->productModel->getProductsByCategory($categoryId);
        $current_category = $category;
        $cartCount = $this->getCartCount();
        include 'app/views/product/list.php';
    }

    public function show($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            http_response_code(404);
            die('Product not found');
        }
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            http_response_code(404);
            die('Product not found');
        }
        $category = $this->categoryModel->getCategoryById($product->category_id);
        $cartCount = $this->getCartCount();
        include 'app/views/product/show.php';
    }

    public function cart()
    {
        $cart = $this->getCart();
        $items = [];
        $subtotal = 0;

        foreach ($cart as $productId => $item) {
            $product = $this->productModel->getProductById($productId);
            if (!$product) {
                continue;
            }

            $quantity = max(1, (int) ($item['quantity'] ?? 1));
            $price = (float) $product->price;
            $lineTotal = $price * $quantity;
            $subtotal += $lineTotal;

            $items[] = [
                'id' => (int) $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $price,
                'quantity' => $quantity,
                'line_total' => $lineTotal,
            ];
        }

        $cartCount = $this->getCartCount();
        include 'app/views/product/cart.php';
    }

    public function addToCart()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('/phamgiahuy/Product');
        }

        $productId = (int) ($_POST['product_id'] ?? 0);
        $quantity = (int) ($_POST['quantity'] ?? 1);
        $quantity = $quantity > 0 ? $quantity : 1;

        $product = $this->productModel->getProductById($productId);
        if (!$product) {
            $this->setFlash('Sản phẩm không tồn tại.', 'danger');
            $this->redirectTo('/phamgiahuy/Product');
        }

        $cart = $this->getCart();
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => (int) $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'image' => $product->image,
                'quantity' => $quantity,
            ];
        }

        $this->saveCart($cart);
        $this->setFlash('Đã thêm sản phẩm vào giỏ hàng.');

        $redirectTo = $_POST['redirect_to'] ?? '/phamgiahuy/Product/cart';
        $this->redirectTo($redirectTo);
    }

    public function updateCart()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('/phamgiahuy/Product/cart');
        }

        $quantities = $_POST['quantity'] ?? [];
        $cart = $this->getCart();

        foreach ($quantities as $productId => $quantity) {
            $productId = (int) $productId;
            $quantity = (int) $quantity;

            if ($quantity <= 0) {
                unset($cart[$productId]);
                continue;
            }

            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $quantity;
            }
        }

        $this->saveCart($cart);
        $this->setFlash('Đã cập nhật giỏ hàng.');
        $this->redirectTo('/phamgiahuy/Product/cart');
    }

    public function removeFromCart($id)
    {
        $productId = (int) $id;
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $this->saveCart($cart);
            $this->setFlash('Đã xóa sản phẩm khỏi giỏ hàng.');
        }

        $this->redirectTo('/phamgiahuy/Product/cart');
    }

    public function clearCart()
    {
        $this->saveCart([]);
        $this->setFlash('Đã xóa toàn bộ giỏ hàng.');
        $this->redirectTo('/phamgiahuy/Product/cart');
    }


    public function checkout()
    {
        $cart = $this->getCart();
        if (empty($cart)) {
            $this->setFlash('Giỏ hàng trống.', 'danger');
            $this->redirectTo('/phamgiahuy/Product/cart');
        }

        $items = [];
        $subtotal = 0;
        foreach ($cart as $productId => $item) {
            $product = $this->productModel->getProductById($productId);
            if (!$product) continue;
            $quantity = max(1, (int) ($item['quantity'] ?? 1));
            $price = (float) $product->price;
            $lineTotal = $price * $quantity;
            $subtotal += $lineTotal;
            $items[] = [
                'id' => (int) $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $price,
                'quantity' => $quantity,
                'line_total' => $lineTotal
            ];
        }
        $cartCount = $this->getCartCount();
        include 'app/views/product/checkout.php';
    }

    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('/phamgiahuy/Product/checkout');
        }
        $cart = $this->getCart();
        if (empty($cart)) {
            $this->redirectTo('/phamgiahuy/Product');
        }
        $name = $_POST['name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        if (empty($name) || empty($phone) || empty($address)) {
            $this->setFlash('Vui lòng điền đầy đủ thông tin.', 'danger');
            $this->redirectTo('/phamgiahuy/Product/checkout');
        }
        $items = [];
        foreach ($cart as $productId => $item) {
            $product = $this->productModel->getProductById($productId);
            if (!$product) continue;
            $qty = (int)$item['quantity'];
            $price = (float)$product->price;
            $items[] = [
                'product_id' => $product->id,
                'price' => $price,
                'quantity' => $qty
            ];
        }
        $accountId = $_SESSION['user_id'] ?? null;
        $orderId = $this->orderModel->createOrder($name, $phone, $address, $items, $accountId);
        if ($orderId) {
            $this->saveCart([]);
            $_SESSION['last_order_id'] = $orderId;
            $this->setFlash('Đặt hàng thành công! Mã đơn hàng: #' . $orderId, 'success');
            $this->redirectTo('/phamgiahuy/Product/confirm/' . $orderId);
        } else {
            $this->setFlash('Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại.', 'danger');
            $this->redirectTo('/phamgiahuy/Product/checkout');
        }
    }

    public function confirm($id)
    {
        $order = $this->orderModel->getOrderById($id);
        if (!$order) {
            $this->setFlash('Không tìm thấy đơn hàng.', 'danger');
            $this->redirectTo('/phamgiahuy/Product');
        }

        $isLastPlaced = isset($_SESSION['last_order_id']) && $_SESSION['last_order_id'] == $id;
        $isOwner = isset($_SESSION['user_id']) && $order['account_id'] == $_SESSION['user_id'];
        $isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

        if (!$isAdmin && !$isOwner && !$isLastPlaced) {
            $this->setFlash('Bạn không có quyền xem trang này.', 'danger');
            $this->redirectTo('/phamgiahuy/Product');
        }

        $orderDetails = $this->orderModel->getOrderDetails($id);
        $cartCount = $this->getCartCount();
        include 'app/views/product/confirm.php';
    }

    public function orders()
    {
        $accountId = null;
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $accountId = $_SESSION['user_id'] ?? -1;
        }
        $rawOrders = $this->orderModel->getOrders($accountId);
        $orders = [];
        foreach ($rawOrders as $o) {
            $details = $this->orderModel->getOrderDetails($o['id']);
            $total = 0;
            foreach ($details as $d) {
                $total += $d['price'] * $d['quantity'];
            }
            $orders[] = [
                'id' => $o['id'],
                'date' => $o['order_date'],
                'status' => $o['status'] ?? 'pending',
                'customer' => [
                    'name' => $o['name'],
                    'phone' => $o['phone'],
                    'address' => $o['address']
                ],
                'total' => $total
            ];
        }
        $cartCount = $this->getCartCount();
        include 'app/views/product/orders.php';
    }

    public function orderDetail($id)
    {
        $order = $this->orderModel->getOrderById($id);
        if (!$order) {
            $this->setFlash('Không tìm thấy đơn hàng.', 'danger');
            $this->redirectTo('/phamgiahuy/Product/orders');
        }

        $isOwner = isset($_SESSION['user_id']) && $order['account_id'] == $_SESSION['user_id'];
        $isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

        if (!$isAdmin && !$isOwner) {
            $this->setFlash('Bạn không có quyền xem chi tiết đơn hàng này.', 'danger');
            $this->redirectTo('/phamgiahuy/Product/orders');
        }

        $orderDetails = $this->orderModel->getOrderDetails($id);
        $order['items'] = [];
        $order['total'] = 0;
        foreach ($orderDetails as $detail) {
            $lineTotal = $detail['price'] * $detail['quantity'];
                $order['items'][] = [
                    'product_id' => $detail['product_id'],
                    'name' => $detail['name'] ?? 'Sản phẩm đã bị xóa',
                    'image' => $detail['image'] ?? '',
                    'price' => $detail['price'],
                    'quantity' => $detail['quantity'],
                    'line_total' => $lineTotal
                ];
            $order['total'] += $lineTotal;
        }
        $order['customer'] = [
            'name' => $order['name'],
            'phone' => $order['phone'],
            'address' => $order['address']
        ];
        $order['date'] = $order['order_date'];
        $cartCount = $this->getCartCount();
        include 'app/views/product/orderDetail.php';
    }

    public function add()
    {
        $this->checkAdmin();
        $categories = $this->categoryModel->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];

            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $maxSize = 5 * 1024 * 1024;

                if (in_array($ext, $allowed) && $_FILES['image']['size'] <= $maxSize) {
                    $filename = uniqid('product_', true) . '.' . $ext;
                    move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $filename);
                    $image = $filename;
                }
            }

            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

            if (is_array($result)) {
                $errors = $result;
                $categories = $this->categoryModel->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /phamgiahuy/Product');
                exit;
            }
        }
    }

    public function edit($id)
    {
        $this->checkAdmin();
        if (!is_numeric($id) || $id <= 0) {
            echo 'Invalid product ID';
            return;
        }
        $product = $this->productModel->getProductById($id);
        $categories = $this->categoryModel->getCategories();

        if ($product) {
           include 'app/views/product/edit.php';
        } else {
            echo 'Product not found';
        }
    }

    public function update()
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];

            $existingProduct = $this->productModel->getProductById($id);
            $image = $existingProduct ? $existingProduct->image : null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $maxSize = 5 * 1024 * 1024;

                if (in_array($ext, $allowed) && $_FILES['image']['size'] <= $maxSize) {
                    $filename = uniqid('product_', true) . '.' . $ext;
                    move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $filename);
                    $image = $filename;
                }
            }

            $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);

            if (is_array($edit)) {
                $errors = $edit;
                $product = $this->productModel->getProductById($id);
                $categories = $this->categoryModel->getCategories();
                include 'app/views/product/edit.php';
            } elseif ($edit) {
                header('Location: /phamgiahuy/Product');
                exit;
            } else {
                echo 'Error updating product';
            }
        }
    }

    public function delete($id)
    {
        $this->checkAdmin();
        if (!is_numeric($id) || $id <= 0) {
            echo 'Invalid product ID';
            return;
        }
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /phamgiahuy/Product');
            exit;
        } else {
            echo 'Error deleting product';
        }
    }
}
