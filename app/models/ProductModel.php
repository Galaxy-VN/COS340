<?php

class ProductModel
{
    private $conn;
    private $table_name = "product";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getProducts()
    {
        $query =
            "SELECT p.id, p.name, p.description, p.price, p.category_id, c.name as category_name
                  FROM " .
            $this->table_name .
            " p
                  LEFT JOIN category c ON p.category_id = c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getProductsByCategory($category_id)
    {
        $query =
            "SELECT p.id, p.name, p.description, p.price, p.category_id, c.name as category_name
                  FROM " .
            $this->table_name .
            " p
                  LEFT JOIN category c ON p.category_id = c.id
                  WHERE p.category_id = :category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":category_id", $category_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getProductById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    private function sanitize(string $value): string
    {
        return htmlspecialchars(strip_tags($value));
    }

    public function addProduct($name, $description, $price, $category_id)
    {
        $errors = [];
        if (trim($name) === "") {
            $errors[] = "Name is required.";
        }
        if (trim($description) === "") {
            $errors[] = "Description is required.";
        }
        if (!is_numeric($price) || $price <= 0) {
            $errors[] = "Valid price is required.";
        }
        if (!is_numeric($category_id) || (int) $category_id <= 0) {
            $errors[] = "Valid category is required.";
        }

        if (!empty($errors)) {
            return $errors;
        }

        $query =
            "INSERT INTO " .
            $this->table_name .
            " (name, description, price, category_id)
                  VALUES (:name, :description, :price, :category_id)";
        $stmt = $this->conn->prepare($query);

        $name = $this->sanitize($name);
        $description = $this->sanitize($description);

        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":description", $description);
        $stmt->bindValue(":price", $price);
        $stmt->bindValue(":category_id", $category_id);

        return $stmt->execute();
    }

    private function validateProductInput(
        $name,
        $description,
        $price,
        $category_id,
    ): array {
        $errors = [];
        if (trim($name) === "") {
            $errors[] = "Name is required.";
        }
        if (trim($description) === "") {
            $errors[] = "Description is required.";
        }
        if (!is_numeric($price) || (float) $price <= 0) {
            $errors[] = "Valid price is required.";
        }
        if (!is_numeric($category_id) || (int) $category_id <= 0) {
            $errors[] = "Valid category is required.";
        }
        return $errors;
    }

    public function updateProduct(
        $id,
        $name,
        $description,
        $price,
        $category_id,
    ) {
        $errors = $this->validateProductInput(
            $name,
            $description,
            $price,
            $category_id,
        );
        if (!empty($errors)) {
            return $errors;
        }

        $name = $this->sanitize($name);
        $description = $this->sanitize($description);

        $query =
            "UPDATE " .
            $this->table_name .
            "
                  SET name = :name, description = :description, price = :price, category_id = :category_id
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":description", $description);
        $stmt->bindValue(":price", $price);
        $stmt->bindValue(":category_id", $category_id);
        if (!$stmt->execute()) {
            return false;
        }
        return $stmt->rowCount() > 0;
    }

    public function deleteProduct($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        if (!$stmt->execute()) {
            return false;
        }
        return $stmt->rowCount() > 0;
    }
}
