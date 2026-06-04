<?php
require_once 'app/config/database.php';
require_once 'app/models/CategoryModel.php';

class CategoryController
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: /phamgiahuy/Product');
            exit;
        }
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    public function index()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    public function add()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];

            $result = $this->categoryModel->addCategory($name, $description);

            if (is_array($result)) {
                $errors = $result;
                $categories = $this->categoryModel->getCategories();
                include 'app/views/category/add.php';
            } else {
                header('Location: /phamgiahuy/Category');
                exit;
            }
        }
    }

    public function edit($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            echo 'Invalid category ID';
            return;
        }
        $category = $this->categoryModel->getCategoryById($id);
        if (!$category) {
            echo 'Category not found';
            return;
        }
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/edit.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];

            $edit = $this->categoryModel->updateCategory($id, $name, $description);

            if ($edit) {
                header('Location: /phamgiahuy/Category');
                exit;
            } else {
                echo 'Error updating category';
            }
        }
    }

    public function delete($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            echo 'Invalid category ID';
            return;
        }
        if ($this->categoryModel->deleteCategory($id)) {
            header('Location: /phamgiahuy/Category');
            exit;
        } else {
            echo 'Error deleting category';
        }
    }
}
