<?php
require_once 'app/config/database.php';
require_once 'app/models/ProductModel.php';
require_once 'app/models/CategoryModel.php';

class ProductController
{
    private $productModel;
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
        $this->categoryModel = new CategoryModel($this->db);
    }

    public function index()
    {
        $categories = $this->categoryModel->getCategories();
        $products = $this->productModel->getProducts();
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
        include 'app/views/product/show.php';
    }


    public function add()
    {
        $categories = $this->categoryModel->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
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
