<?php
require_once "app/config/database.php";
require_once "app/models/CategoryModel.php";

class CategoryApiController
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = new Database()->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
        header("Content-Type: application/json");
    }

    public function index()
    {
        $categories = $this->categoryModel->getCategories();
        echo json_encode($categories);
    }

    public function show($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        if (!$category) {
            http_response_code(404);
            echo json_encode(["error" => "Category not found"]);
            return;
        }
        echo json_encode($category);
    }

    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            http_response_code(405);
            echo json_encode(["error" => "Method not allowed"]);
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid JSON"]);
            return;
        }

        $name = $data["name"] ?? "";
        $description = $data["description"] ?? "";

        $result = $this->categoryModel->addCategory($name, $description);

        if (is_array($result)) {
            http_response_code(422);
            echo json_encode(["errors" => $result]);
            return;
        }

        http_response_code(201);
        echo json_encode(["message" => "Category created successfully"]);
    }

    public function update($id)
    {
        if ($_SERVER["REQUEST_METHOD"] !== "PUT") {
            http_response_code(405);
            echo json_encode(["error" => "Method not allowed"]);
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid JSON"]);
            return;
        }

        $name = $data["name"] ?? "";
        $description = $data["description"] ?? "";

        $result = $this->categoryModel->updateCategory(
            $id,
            $name,
            $description,
        );

        if (is_array($result)) {
            http_response_code(422);
            echo json_encode(["errors" => $result]);
            return;
        }

        if ($result) {
            echo json_encode(["message" => "Category updated successfully"]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Category not found"]);
        }
    }

    public function delete($id)
    {
        if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
            http_response_code(405);
            echo json_encode(["error" => "Method not allowed"]);
            return;
        }

        if ($this->categoryModel->deleteCategory($id)) {
            echo json_encode(["message" => "Category deleted successfully"]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Category not found"]);
        }
    }
}
