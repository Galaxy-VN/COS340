<?php
require_once 'app/config/database.php';
require_once 'app/models/ProductModel.php';

class ProductApiController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
        header('Content-Type: application/json');
    }

    public function index()
    {
        $products = $this->productModel->getProducts();
        echo json_encode($products);
    }

    public function category($categoryId)
    {
        $products = $this->productModel->getProductsByCategory($categoryId);
        echo json_encode($products);
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            http_response_code(404);
            echo json_encode(['error' => 'Product not found']);
            return;
        }
        echo json_encode($product);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON']);
            return;
        }

        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $price = $data['price'] ?? 0;
        $category_id = $data['category_id'] ?? 0;

        $result = $this->productModel->addProduct($name, $description, $price, $category_id);

        if (is_array($result)) {
            http_response_code(422);
            echo json_encode(['errors' => $result]);
            return;
        }

        http_response_code(201);
        echo json_encode(['message' => 'Product created successfully']);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON']);
            return;
        }

        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $price = $data['price'] ?? 0;
        $category_id = $data['category_id'] ?? 0;

        $result = $this->productModel->updateProduct($id, $name, $description, $price, $category_id);

        if (is_array($result)) {
            http_response_code(422);
            echo json_encode(['errors' => $result]);
            return;
        }

        if ($result) {
            echo json_encode(['message' => 'Product updated successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Product not found']);
        }
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        if ($this->productModel->deleteProduct($id)) {
            echo json_encode(['message' => 'Product deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Product not found']);
        }
    }
}
