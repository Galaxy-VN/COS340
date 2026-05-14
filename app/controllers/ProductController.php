<?php

require_once 'app/models/ProductModel.php';

class ProductController
{
    private $products = [];
    private $uploadDir = 'public/images/';

    public function __construct()
    {
        session_start();
        if (isset($_SESSION['products'])) {
            $this->products = $_SESSION['products'];
        }
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    public function index()
    {
        $this->list();
    }

    public function list()
    {
        $products = $this->products;
        include 'app/views/product/list.php';
    }

    public function add()
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $image = '';

            if (empty($name)) {
                $errors[] = 'Tên sản phẩm là bắt buộc.';
            } elseif (strlen($name) < 10 || strlen($name) > 100) {
                $errors[] = 'Tên sản phẩm phải có từ 10 đến 100 ký tự.';
            }

            if (!is_numeric($price) || $price <= 0) {
                $errors[] = 'Giá phải là một số dương lớn hơn 0.';
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $maxSize = 5 * 1024 * 1024; // 5MB

                if (!in_array($ext, $allowed)) {
                    $errors[] = 'Chỉ chấp nhận file ảnh: JPG, JPEG, PNG, GIF, WEBP.';
                } elseif ($_FILES['image']['size'] > $maxSize) {
                    $errors[] = 'Kích thước ảnh không được vượt quá 5MB.';
                } else {
                    $filename = uniqid('product_', true) . '.' . $ext;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $this->uploadDir . $filename)) {
                        $image = $filename;
                    } else {
                        $errors[] = 'Không thể upload ảnh, vui lòng thử lại.';
                    }
                }
            }

            if (empty($errors)) {
                $id = count($this->products) + 1;
                $product = new ProductModel($id, $name, $description, $price, $image);
                $this->products[] = $product;

                $_SESSION['products'] = $this->products;

                header('Location: /phamgiahuy/Product/list');
                exit();
            }
        }

        include 'app/views/product/add.php';
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            foreach ($this->products as $key => $product) {
                if ($product->getID() == $id) {
                    $this->products[$key]->setName($_POST['name']);
                    $this->products[$key]->setDescription($_POST['description']);
                    $this->products[$key]->setPrice($_POST['price']);

                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                        $maxSize = 5 * 1024 * 1024;

                        if (!in_array($ext, $allowed)) {
                            $errors[] = 'Chỉ chấp nhận file ảnh: JPG, JPEG, PNG, GIF, WEBP.';
                        } elseif ($_FILES['image']['size'] > $maxSize) {
                            $errors[] = 'Kích thước ảnh không được vượt quá 5MB.';
                        } else {
                            // Xóa ảnh cũ nếu có
                            $oldImage = $product->getImage();
                            if ($oldImage && file_exists($this->uploadDir . $oldImage)) {
                                unlink($this->uploadDir . $oldImage);
                            }

                            $filename = uniqid('product_', true) . '.' . $ext;
                            if (move_uploaded_file($_FILES['image']['tmp_name'], $this->uploadDir . $filename)) {
                                $this->products[$key]->setImage($filename);
                            }
                        }
                    }

                    break;
                }
            }

            $_SESSION['products'] = $this->products;

            header('Location: /phamgiahuy/Product/list');
            exit();
        }

        foreach ($this->products as $key => $product) {
            if ($product->getID() == $id) {
                include 'app/views/product/edit.php';
                return;
            }
        }

        die('Product not found');
    }

    public function delete($id)
    {
        foreach ($this->products as $key => $product) {
            if ($product->getID() == $id) {
                $image = $product->getImage();
                if ($image && file_exists($this->uploadDir . $image)) {
                    unlink($this->uploadDir . $image);
                }
                unset($this->products[$key]);
                break;
            }
        }

        $this->products = array_values($this->products);
        $_SESSION['products'] = $this->products;

        header('Location: /phamgiahuy/Product/list');
        exit();
    }
}

?>